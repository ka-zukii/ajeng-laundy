<?php

namespace App\Services\Pembayaran;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MidtransCallbackService
{
    public function __construct(
        protected PaymentService $paymentService,
    ) {}

    /**
     * Menangani callback dari Midtrans.
     */
    public function handle(Request $request): void
    {
        $payload = $request->all();

        Log::info('=== MIDTRANS CALLBACK ===', $payload);

        if (empty($payload)) {
            throw new HttpException(
                400,
                'Payload callback kosong.'
            );
        }

        $this->verifySignature($payload);

        DB::transaction(function () use ($payload) {

            /** @var Pembayaran|null $pembayaran */
            $pembayaran = Pembayaran::where(
                'midtrans_order_id',
                $payload['order_id']
            )->first();

            if (! $pembayaran) {
                throw new HttpException(
                    404,
                    'Pembayaran tidak ditemukan. Order ID: ' . $payload['order_id']
                );
            }

            $bank = null;
            $vaNumber = null;

            if (! empty($payload['va_numbers'])) {
                $bank = $payload['va_numbers'][0]['bank'] ?? null;
                $vaNumber = $payload['va_numbers'][0]['va_number'] ?? null;
            }

            $pembayaran->update([
                'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
                'transaction_status'      => $payload['transaction_status'] ?? null,
                'payment_type'            => $payload['payment_type'] ?? null,
                'bank'                    => $bank,
                'va_number'               => $vaNumber,
                'expired_at'              => isset($payload['expiry_time'])
                    ? date('Y-m-d H:i:s', strtotime($payload['expiry_time']))
                    : null,
            ]);

            switch ($payload['transaction_status']) {

                case 'capture':
                    if (($payload['fraud_status'] ?? '') === 'accept') {
                        $this->paymentService->markAsPaid($pembayaran);
                    }
                    break;

                case 'settlement':
                    $this->paymentService->markAsPaid($pembayaran);
                    break;

                case 'pending':
                    $this->paymentService->markAsPending($pembayaran);
                    break;

                case 'expire':
                    $this->paymentService->markAsCancelled(
                        $pembayaran,
                        'Pembayaran kedaluwarsa.',
                    );
                    break;

                case 'cancel':
                    $this->paymentService->markAsCancelled(
                        $pembayaran,
                        'Pembayaran dibatalkan oleh pengguna.',
                    );
                    break;

                case 'deny':
                    $this->paymentService->markAsCancelled(
                        $pembayaran,
                        'Pembayaran ditolak oleh Midtrans.',
                    );
                    break;
            }

            Log::info('=== MIDTRANS CALLBACK SUCCESS ===', [
                'order_id' => $payload['order_id'],
                'transaction_status' => $payload['transaction_status'],
            ]);
        });
    }

    /**
     * Memverifikasi signature callback Midtrans.
     */
    private function verifySignature(array $payload): void
    {
        if (
            ! isset(
                $payload['order_id'],
                $payload['status_code'],
                $payload['gross_amount'],
                $payload['signature_key'],
            )
        ) {
            throw new HttpException(
                400,
                'Payload Midtrans tidak lengkap.'
            );
        }

        $serverKey = config('services.midtrans.server_key');

        $expectedSignature = hash(
            'sha512',
            $payload['order_id']
                . $payload['status_code']
                . $payload['gross_amount']
                . $serverKey
        );

        if (! hash_equals(
            $expectedSignature,
            $payload['signature_key']
        )) {
            throw new HttpException(
                403,
                'Invalid Midtrans signature.'
            );
        }
    }
}
