<?php

namespace App\Services\Transaksi;

use App\Enums\PrioritasLaundry;
use App\Enums\StatusLaundry;
use App\Models\Layanan;
use App\Models\NodaPakaian;
use App\Models\Transaksi;
use Carbon\Carbon;

class FuzzyLaundryService
{
    public function calculate(
        Layanan $layanan,
        ?NodaPakaian $noda,
        array $data,
        Carbon $tanggalMasuk,
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Input Fuzzy
        |--------------------------------------------------------------------------
        */

        $berat = (float) ($data['berat'] ?? 0);

        $jumlah = (int) ($data['jumlah'] ?? 0);

        $tingkatKekotoran = (int) ($data['tingkat_kekotoran'] ?? 0);

        $lamaMenunggu = $tanggalMasuk->diffInHours(now());

        $jumlahAntrean = $this->getQueueCount();

        /*
        |--------------------------------------------------------------------------
        | Perhitungan Fuzzy (sementara)
        |--------------------------------------------------------------------------
        */

        $durasiJam = $this->calculateDuration(
            layanan: $layanan,
            noda: $noda,
            berat: $berat,
            jumlah: $jumlah,
            tingkatKekotoran: $tingkatKekotoran,
            lamaMenunggu: $lamaMenunggu,
            jumlahAntrean: $jumlahAntrean,
        );

        $prioritas = $this->calculatePriority(
            durasiJam: $durasiJam,
            tingkatKekotoran: $tingkatKekotoran,
        );

        return [
            'durasi_jam' => $durasiJam,
            'estimasi_selesai' => $tanggalMasuk
                ->copy()
                ->addHours($durasiJam),
            'prioritas' => $prioritas,
        ];
    }

    /**
     * Menghitung jumlah antrean laundry aktif.
     */
    private function getQueueCount(): int
    {
        return Transaksi::query()
            ->whereIn('status_laundry', [
                StatusLaundry::PENDING,
                StatusLaundry::DIPROSES,
            ])
            ->count();
    }

    /**
     * Placeholder perhitungan durasi.
     *
     * Nanti seluruh isi method ini diganti dengan
     * Fuzzy Sugeno.
     */
    private function calculateDuration(
        Layanan $layanan,
        ?NodaPakaian $noda,
        float $berat,
        int $jumlah,
        int $tingkatKekotoran,
        int $lamaMenunggu,
        int $jumlahAntrean,
    ): int {

        /*
        |--------------------------------------------------------------------------
        | TODO
        |--------------------------------------------------------------------------
        |
        | Berat
        | Jumlah
        | Tingkat Kekotoran
        | Lama Menunggu
        | Jumlah Antrean
        |
        | Akan diproses menggunakan
        | Fuzzy Sugeno.
        |
        */

        return 24;
    }

    /**
     * Placeholder menentukan prioritas.
     */
    private function calculatePriority(
        int $durasiJam,
        int $tingkatKekotoran,
    ): PrioritasLaundry {

        if ($tingkatKekotoran >= 80) {
            return PrioritasLaundry::HIGH;
        }

        if ($tingkatKekotoran >= 50) {
            return PrioritasLaundry::MEDIUM;
        }

        return PrioritasLaundry::LOW;
    }
}
