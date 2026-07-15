<?php

namespace App\Services\Transaksi;

use App\Enums\JenisPerhitungan;
use App\Models\Layanan;
use App\Models\NodaPakaian;

class TransactionCalculator
{
    public function total(
        Layanan $layanan,
        ?NodaPakaian $noda,
        array $data,
    ): float {

        $subtotal = match ($layanan->jenis_perhitungan) {

            JenisPerhitungan::KILOAN =>
            $layanan->biaya_layanan * ($data['berat'] ?? 0),

            JenisPerhitungan::SATUAN =>
            $layanan->biaya_layanan * ($data['jumlah'] ?? 0),
        };

        return $subtotal + ($noda?->biaya_tambahan ?? 0);
    }
}
