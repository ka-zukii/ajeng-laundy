<?php

namespace App\Services\Transaksi;

use App\Enums\PrioritasLaundry;
use App\Models\Layanan;
use App\Models\NodaPakaian;
use Carbon\Carbon;

class FuzzyLaundryService
{
    public function calculate(
        Layanan $layanan,
        ?NodaPakaian $noda,
        array $data,
        Carbon $tanggalMasuk,
    ): array {

        return [
            'estimasi_selesai' => $tanggalMasuk,
            'prioritas' => PrioritasLaundry::LOW,
        ];
    }
}