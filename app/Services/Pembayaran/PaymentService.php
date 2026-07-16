<?php

namespace App\Services\Pembayaran;

use App\Enums\StatusPembayaran;
use App\Models\Pembayaran;
use App\Models\Transaksi;

class PaymentService
{
    public function create(
        Transaksi $transaksi,
        float $total,
    ): Pembayaran {
        return $transaksi->pembayaran()->create([
            'jumlah_pembayaran' => $total,
            'status_pembayaran' => StatusPembayaran::MENGUNGGU,
        ]);
    }

    public function updateAmount(
        Transaksi $transaksi,
        float $total,
    ): void {
        $transaksi->pembayaran()->update([
            'jumlah_pembayaran' => $total,
        ]);
    }
}
