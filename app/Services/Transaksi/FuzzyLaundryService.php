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
        | Perhitungan Fuzzy
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
            lamaMenunggu: $lamaMenunggu,
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

    /*
    |--------------------------------------------------------------------------
    | 1. PROSES ESTIMASI DURASI (FUZZY SUGENO)
    |--------------------------------------------------------------------------
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
        // Gabungkan beban (jika kiloan pakai berat, jika satuan pakai jumlah)
        $beban = $berat > 0 ? $berat : ($jumlah * 0.2); // Konversi kasar satuan ke bobot setara kg

        // Tahap A: Fuzzifikasi
        $muBeban = $this->fuzzifyBeban($beban);
        $muAntrean = $this->fuzzifyAntrean($jumlahAntrean);
        $muKekotoran = $this->fuzzifyKekotoran($tingkatKekotoran);

        // Konstanta Konsekuen Sugeno (Orde-0) dalam satuan Jam
        $outputSelesai = [
            'cepat'  => 6,
            'normal' => 24,
            'lama'   => 48
        ];

        // Tahap B: Evaluasi Rule & Implikasi (MIN)
        $rules = [];

        // R1: JIKA Beban RINGAN dan Antrean SEDIKIT -> CEPAT
        $rules[] = ['w' => min($muBeban['ringan'], $muAntrean['sedikit']), 'z' => $outputSelesai['cepat']];
        // R2: JIKA Antrean BANYAK -> LAMA
        $rules[] = ['w' => $muAntrean['banyak'], 'z' => $outputSelesai['lama']];
        // R3: JIKA Beban BERAT atau Kekotoran TINGGI -> LAMA
        $rules[] = ['w' => max($muBeban['berat'], $muKekotoran['tinggi']), 'z' => $outputSelesai['lama']];
        // R4: JIKA Beban SEDANG dan Antrean SEDIKIT dan Kekotoran SEDANG -> NORMAL
        $rules[] = ['w' => min($muBeban['sedang'], $muAntrean['sedikit'], $muKekotoran['sedang']), 'z' => $outputSelesai['normal']];

        // Tahap C: Defuzzifikasi
        return (int) round($this->defuzzifySugeno($rules, 24));
    }

    /*
    |--------------------------------------------------------------------------
    | 2. PROSES PENENTUAN PRIORITAS (FUZZY SUGENO)
    |--------------------------------------------------------------------------
    */

    private function calculatePriority(
        int $durasiJam,
        int $tingkatKekotoran,
        int $lamaMenunggu
    ): PrioritasLaundry {
        // Tahap A: Fuzzifikasi
        $muKekotoran = $this->fuzzifyKekotoran($tingkatKekotoran);
        $muMenunggu = $this->fuzzifyWaktuTunggu($lamaMenunggu);

        // Konstanta Konsekuen Sugeno (Orde-0) untuk Tingkat Prioritas
        $outputPrioritas = [
            'rendah' => 1.0,
            'sedang' => 2.0,
            'tinggi' => 3.0
        ];

        // Tahap B: Evaluasi Rule & Implikasi
        $rules = [];

        // R1: JIKA Lama Menunggu LAMA -> TINGGI (Pelanggan komplain/menunggu lama wajib didahulukan)
        $rules[] = ['w' => $muMenunggu['lama'], 'z' => $outputPrioritas['tinggi']];
        // R2: JIKA Kekotoran TINGGI -> SEDANG
        $rules[] = ['w' => $muKekotoran['tinggi'], 'z' => $outputPrioritas['sedang']];
        // R3: JIKA Kekotoran RENDAH dan Waktu Menunggu BARU -> RENDAH
        $rules[] = ['w' => min($muKekotoran['rendah'], $muMenunggu['baru']), 'z' => $outputPrioritas['rendah']];

        // Tahap C: Defuzzifikasi
        $skalaPrioritas = $this->defuzzifySugeno($rules, 1.0);

        // Konversi nilai tegas Sugeno ke bentuk Enum
        if ($skalaPrioritas >= 2.5) {
            return PrioritasLaundry::HIGH;
        }
        if ($skalaPrioritas >= 1.5) {
            return PrioritasLaundry::MEDIUM;
        }
        return PrioritasLaundry::LOW;
    }

    /*
    |--------------------------------------------------------------------------
    | 3. ENGINE DEFUZZIFIKASI (Weighted Average)
    |--------------------------------------------------------------------------
    */

    private function defuzzifySugeno(array $rules, float $default): float
    {
        $sumW = 0;
        $sumWZ = 0;

        foreach ($rules as $rule) {
            if ($rule['w'] > 0) {
                $sumW += $rule['w'];
                $sumWZ += $rule['w'] * $rule['z'];
            }
        }

        return $sumW > 0 ? ($sumWZ / $sumW) : $default;
    }

    /*
    |--------------------------------------------------------------------------
    | 4. FUNGSI KEANGGOTAAN FUZZIFIKASI (Membership Functions)
    |--------------------------------------------------------------------------
    */

    private function fuzzifyBeban(float $x): array
    {
        return [
            'ringan' => $this->linearTurun($x, 2, 5),
            'sedang' => $this->segitiga($x, 3, 6, 9),
            'berat'  => $this->linearNaik($x, 7, 12),
        ];
    }

    private function fuzzifyAntrean(int $x): array
    {
        return [
            'sedikit' => $this->linearTurun($x, 3, 8),
            'banyak'  => $this->linearNaik($x, 5, 15),
        ];
    }

    private function fuzzifyKekotoran(int $x): array
    {
        // Skala 0 - 100
        return [
            'rendah' => $this->linearTurun($x, 20, 50),
            'sedang' => $this->segitiga($x, 35, 60, 85),
            'tinggi' => $this->linearNaik($x, 70, 90),
        ];
    }

    private function fuzzifyWaktuTunggu(int $x): array
    {
        // Satuan Jam
        return [
            'baru' => $this->linearTurun($x, 2, 6),
            'lama' => $this->linearNaik($x, 4, 12),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 5. OPERATOR KURVA STANDAR
    |--------------------------------------------------------------------------
    */

    private function linearTurun(float $x, float $a, float $b): float
    {
        if ($x <= $a) return 1.0;
        if ($x >= $b) return 0.0;
        return ($b - $x) / ($b - $a);
    }

    private function linearNaik(float $x, float $a, float $b): float
    {
        if ($x <= $a) return 0.0;
        if ($x >= $b) return 1.0;
        return ($x - $a) / ($b - $a);
    }

    private function segitiga(float $x, float $a, float $b, float $c): float
    {
        if ($x <= $a || $x >= $c) return 0.0;
        if ($x == $b) return 1.0;
        if ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
        return ($c - $x) / ($c - $b);
    }
}
