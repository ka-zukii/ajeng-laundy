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
    private const JUMLAH_MESIN = 5;
    private const WAKTU_SIKLUS_MESIN = 3;

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
        $berat = (float) ($data['berat'] ?? 0);
        $jumlah = (int) ($data['jumlah'] ?? 0);
        $tingkatKekotoran = (int) ($data['tingkat_kekotoran'] ?? 0);

        $lamaMenunggu = $tanggalMasuk->diffInHours(now());
        $jumlahAntreanTotal = $this->getQueueCount();

        $antreanPerMesin = (int) ceil($jumlahAntreanTotal / self::JUMLAH_MESIN);

        $waktuTungguAntrean = floor($jumlahAntreanTotal / self::JUMLAH_MESIN) * self::WAKTU_SIKLUS_MESIN;

        $waktuProsesPesanan = self::WAKTU_SIKLUS_MESIN + ($berat > 10 ? 1 : 0);

        $totalDurasiFisik = $waktuTungguAntrean + $waktuProsesPesanan;

        $durasiFuzzy = $this->durationEvaluator->calculate(
            berat: $berat,
            jumlah: $jumlah,
            tingkatKekotoran: $tingkatKekotoran,
            jumlahAntrean: $antreanPerMesin
        );

        $prioritas = $this->priorityEvaluator->calculate(
            tingkatKekotoran: $tingkatKekotoran,
            lamaMenunggu: $lamaMenunggu
        );

        $durasiJanjiKePelanggan = (int) max($durasiFuzzy, $totalDurasiFisik);

        return [
            'durasi_jam'       => $durasiJanjiKePelanggan,
            'estimasi_selesai' => $tanggalMasuk->copy()->addHours($durasiJanjiKePelanggan),
            'prioritas'        => $prioritas,
        ];
    }

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
