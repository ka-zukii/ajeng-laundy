<?php

namespace App\Services\Transaksi;

use App\Enums\PrioritasLaundry;
use App\Enums\JenisPerhitungan;
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
        $durasiJam = 24;

        // logika sementara

        if ($layanan->jenis_perhitungan === JenisPerhitungan::KILOAN) {

            $berat = (float) ($data['berat'] ?? 0);

            if ($berat >= 10) {
                $durasiJam += 12;
            } elseif ($berat >= 5) {
                $durasiJam += 6;
            }
        }

        if ($layanan->jenis_perhitungan === JenisPerhitungan::SATUAN) {

            $jumlah = (int) ($data['jumlah'] ?? 0);

            if ($jumlah >= 20) {
                $durasiJam += 12;
            } elseif ($jumlah >= 10) {
                $durasiJam += 6;
            }
        }

        if ($noda !== null) {
            $durasiJam += 4;
        }

        $tingkatKekotoran = (int) ($data['tingkat_kekotoran'] ?? 0);

        if ($tingkatKekotoran >= 80) {
            $prioritas = PrioritasLaundry::HIGH;
        } elseif ($tingkatKekotoran >= 50) {
            $prioritas = PrioritasLaundry::MEDIUM;
        } else {
            $prioritas = PrioritasLaundry::LOW;
        }

        return [
            'durasi_jam' => $durasiJam,

            'estimasi_selesai' => $tanggalMasuk
                ->copy()
                ->addHours($durasiJam),

            'prioritas' => $prioritas,
        ];
    }
}
