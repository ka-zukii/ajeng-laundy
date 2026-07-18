<?php

namespace App\Services\Pembayaran;

use App\Enums\StatusPembayaran;
use App\Models\Pembayaran;
use App\Models\Transaksi;

class PaymentService
{
    public function __construct(
        protected MidtransService $midtrans,
    ) {}

    /**
     * Membuat data pembayaran baru beserta Snap Token Midtrans.
     */
    public function create(
        Transaksi $transaksi,
        float $total,
    ): Pembayaran {
        $pembayaran = $transaksi->pembayaran()->create([
            'jumlah_pembayaran' => $total,
            'payment_gateway' => 'midtrans',
            'status_pembayaran' => StatusPembayaran::MENGUNGGU,
        ]);

        $snapToken = $this->midtrans->createSnapToken(
            $transaksi->fresh([
                'pelanggan',
                'transaksiDetail.layanan',
                'pembayaran',
            ]),
        );

        $pembayaran->update([
            'snap_token' => $snapToken,
        ]);

        return $pembayaran->fresh();
    }

    /**
     * Mengulangi pembayaran beserta Snap Token Midtrans.
     */
    public function retry(Pembayaran $pembayaran): void
    {
        $newOrderId = sprintf(
            '%s-%s',
            $pembayaran->transaksi->kode_transaksi,
            now()->format('YmdHisv'),
        );

        $pembayaran->update([
            'midtrans_order_id' => $newOrderId,
            'status_pembayaran' => StatusPembayaran::MENGUNGGU,

            // Reset data Midtrans
            'payment_type' => null,
            'bank' => null,
            'va_number' => null,
            'midtrans_transaction_id' => null,
            'transaction_status' => null,
            'tanggal_pembayaran' => null,
            'expired_at' => null,
            'catatan' => null,
            'snap_token' => null,
        ]);

        $pembayaran->update([
            'snap_token' => $this->midtrans->createSnapToken(
                $pembayaran->transaksi->fresh([
                    'pelanggan',
                    'transaksiDetail.layanan',
                    'pembayaran',
                ]),
            ),
        ]);
    }

    /**
     * Mengubah nominal pembayaran.
     */
    public function updateAmount(
        Transaksi $transaksi,
        float $total,
    ): void {
        $transaksi->pembayaran()->update([
            'jumlah_pembayaran' => $total,
        ]);
    }

    /**
     * Memperbarui Snap Token.
     */
    public function refreshSnapToken(
        Transaksi $transaksi,
    ): void {
        $snapToken = $this->midtrans->createSnapToken($transaksi);
        $transaksi->pembayaran()->update([
            'snap_token' => $snapToken,
        ]);
    }

    /**
     * Tandai pembayaran berhasil.
     */
    public function markAsPaid(
        Pembayaran $pembayaran,
    ): void {
        $pembayaran->update([
            'status_pembayaran' => StatusPembayaran::SUKSES,
            'tanggal_pembayaran' => now(),
        ]);
    }

    /**
     * Tandai pembayaran masih menunggu.
     */
    public function markAsPending(
        Pembayaran $pembayaran,
    ): void {
        $pembayaran->update([
            'status_pembayaran' => StatusPembayaran::MENGUNGGU,
        ]);
    }

    /**
     * Tandai pembayaran dibatalkan.
     */
    public function markAsCancelled(
        Pembayaran $pembayaran,
        ?string $note = null,
    ): void {
        $pembayaran->update([
            'status_pembayaran' => StatusPembayaran::DIBATALKAN,
            'catatan' => $note,
        ]);
    }

    /**
     * Sinkronkan nominal transaksi dengan pembayaran.
     */
    public function syncAmount(
        Transaksi $transaksi,
    ): void {
        $this->updateAmount(
            $transaksi,
            (float) $transaksi->total_biaya,
        );
    }

    /**
     * Sinkronkan nominal dan Snap Token.
     */
    public function sync(
        Transaksi $transaksi,
    ): void {
        $this->updateAmount(
            $transaksi,
            (float) $transaksi->total_biaya,
        );
        $this->refreshSnapToken($transaksi);
    }
}
