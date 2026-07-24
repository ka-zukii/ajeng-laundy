<?php

namespace App\Services\Transaksi;

use App\Enums\StatusLaundry;
use App\Models\Layanan;
use App\Models\NodaPakaian;
use App\Models\Transaksi;
use App\Services\Transaksi\Fuzzy\DurationEvaluator;
use App\Services\Transaksi\Fuzzy\PriorityEvaluator;
use Carbon\Carbon;

class FuzzyLaundryService
{
    public function __construct(
        private DurationEvaluator $durationEvaluator,
        private PriorityEvaluator $priorityEvaluator
    ) {}

    public function calculate(
        Layanan $layanan,
        ?NodaPakaian $noda,
        array $data,
        Carbon $tanggalMasuk,
    ): array {

        // 1. Ekstraksi dan Persiapan Data
        $berat = (float) ($data['berat'] ?? 0);
        $jumlah = (int) ($data['jumlah'] ?? 0);
        $tingkatKekotoran = (int) ($data['tingkat_kekotoran'] ?? 0);

        $lamaMenunggu = $tanggalMasuk->diffInHours(now());
        $jumlahAntrean = $this->getQueueCount();

        // 2. Eksekusi Fuzzy Rules
        $durasiJam = $this->durationEvaluator->calculate(
            berat: $berat,
            jumlah: $jumlah,
            tingkatKekotoran: $tingkatKekotoran,
            jumlahAntrean: $jumlahAntrean
        );

        $prioritas = $this->priorityEvaluator->calculate(
            tingkatKekotoran: $tingkatKekotoran,
            lamaMenunggu: $lamaMenunggu
        );

        // 3. Output Format
        return [
            'durasi_jam'       => $durasiJam,
            'estimasi_selesai' => $tanggalMasuk->copy()->addHours($durasiJam),
            'prioritas'        => $prioritas,
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
}
