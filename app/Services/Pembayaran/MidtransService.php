<?php

namespace App\Services\Pembayaran;

use App\Models\Transaksi;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        // dd(config('services.midtrans'));
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    /**
     * Membuat Snap Token.
     */
    public function createSnapToken(
        Transaksi $transaksi,
    ): string {
        $orderId = $transaksi->pembayaran?->midtrans_order_id;

        if (blank($orderId)) {

            $orderId = $this->generateOrderId($transaksi);

            $transaksi->pembayaran()->update([
                'midtrans_order_id' => $orderId,
            ]);

            // Refresh relasi agar objek transaksi ikut terbarui
            $transaksi->load('pembayaran');
        }

        $transaksi->loadMissing([
            'pelanggan',
            'transaksiDetail.layanan',
        ]);

        $params = [

            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $transaksi->total_biaya,
            ],

            'customer_details' => [
                'first_name' => $transaksi->pelanggan->nama,
                'phone' => $transaksi->pelanggan->nomor_telepon,
                'email' => $transaksi->pelanggan->user->email ?? null,
                'billing_address' => [
                    'address' => $transaksi->pelanggan->alamat ?? '',
                ],
            ],

            'item_details' => [
                [
                    'id' => $transaksi->transaksiDetail->layanan_id,
                    'price' => (int) $transaksi->total_biaya,
                    'quantity' => 1,
                    'name' => $transaksi->transaksiDetail->layanan->nama_layanan,
                ],
            ],

        ];

        return Snap::getSnapToken($params);
    }

    protected function generateOrderId(Transaksi $transaksi): string
    {
        return sprintf(
            '%s-%s',
            $transaksi->kode_transaksi,
            now()->format('YmdHisv'),
        );
    }

    /**
     * Mengambil status transaksi dari Midtrans.
     */
    public function status(
        string $orderId,
    ): mixed {
        return Transaction::status($orderId);
    }

    /**
     * Membatalkan transaksi.
     */
    public function cancel(
        string $orderId,
    ): mixed {
        return Transaction::cancel($orderId);
    }

    /**
     * Mengakhiri transaksi (Expire).
     */
    public function expire(
        string $orderId,
    ): mixed {
        return Transaction::expire($orderId);
    }
}
