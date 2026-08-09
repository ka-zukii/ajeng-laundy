<?php

namespace App\Services\Pembayaran;

use App\Enums\StatusPembayaran;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Midtrans\Config;
use Midtrans\CoreApi;

class PaymentService
{
    public function __construct(
        protected MidtransService $midtrans,
    ) {}

    public function chargeCoreApi(Pembayaran $pembayaran, string $metode): object
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = sprintf('%s-%s', $pembayaran->transaksi->kode_transaksi, now()->format('YmdHisv'));

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $pembayaran->jumlah_pembayaran,
            ],
            'customer_details' => [
                'first_name' => $pembayaran->transaksi->pelanggan->nama ?? 'Pelanggan',
                'phone' => $pembayaran->transaksi->pelanggan->no_hp ?? '-',
            ]
        ];

        if (in_array($metode, ['bca_va', 'bni_va', 'bri_va'])) {
            $bank = str_replace('_va', '', $metode);
            $params['payment_type'] = 'bank_transfer';
            $params['bank_transfer'] = ['bank' => $bank];
        } elseif ($metode === 'mandiri_va') {
            $params['payment_type'] = 'echannel';
            $params['echannel'] = [
                'bill_info1' => 'Pembayaran',
                'bill_info2' => 'Laundry'
            ];
        } elseif ($metode === 'gopay') {
            $params['payment_type'] = 'gopay';
            $params['gopay'] = [
                'callback_url' => route('pembayaran.instruksi', $pembayaran->transaksi_id)
            ];
        } elseif ($metode === 'shopeepay') {
            $params['payment_type'] = 'shopeepay';
            $params['shopeepay'] = [
                'callback_url' => route('pembayaran.instruksi', $pembayaran->transaksi_id)
            ];
        } elseif ($metode === 'qris') {
            $params['payment_type'] = 'qris';
        } else {
            throw new \Exception("Metode pembayaran '$metode' tidak valid.");
        }

        $response = CoreApi::charge($params);

        $updateData = [
            'midtrans_order_id' => $orderId,
            'midtrans_transaction_id' => $response->transaction_id,
            'payment_type' => $params['payment_type'],
            'transaction_status' => $response->transaction_status,
        ];

        if ($params['payment_type'] === 'bank_transfer' && isset($response->va_numbers[0])) {
            $updateData['bank'] = $response->va_numbers[0]->bank;
            $updateData['va_number'] = $response->va_numbers[0]->va_number;
        } elseif ($params['payment_type'] === 'echannel') {
            $updateData['bank'] = 'mandiri';
            $updateData['va_number'] = $response->biller_code . $response->bill_key;
        }

        if (in_array($params['payment_type'], ['qris', 'gopay', 'shopeepay']) && isset($response->actions)) {
            foreach ($response->actions as $action) {
                if (in_array($action->name, ['generate-qr-code', 'deeplink-redirect'])) {
                    $updateData['catatan'] = $action->url;
                    break;
                }
            }
            if (!isset($updateData['catatan'])) {
                $updateData['catatan'] = $response->actions[0]->url ?? null;
            }
        }

        $pembayaran->update($updateData);

        return $response;
    }

    public function create(
        Transaksi $transaksi,
        float $total,
    ): Pembayaran {
        $pembayaran = $transaksi->pembayaran()->create([
            'jumlah_pembayaran' => $total,
            'payment_gateway' => 'midtrans',
            'status_pembayaran' => StatusPembayaran::MENGUNGGU,
        ]);

        // $snapToken = $this->midtrans->createSnapToken(
        //     $transaksi->fresh([
        //         'pelanggan',
        //         'transaksiDetail.layanan',
        //         'pembayaran',
        //     ]),
        // );

        // $pembayaran->update([
        //     'snap_token' => $snapToken,
        // ]);

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

        // $pembayaran->update([
        //     'snap_token' => $this->midtrans->createSnapToken(
        //         $pembayaran->transaksi->fresh([
        //             'pelanggan',
        //             'transaksiDetail.layanan',
        //             'pembayaran',
        //         ]),
        //     ),
        // ]);
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
