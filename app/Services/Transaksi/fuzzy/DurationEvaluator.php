<?php

namespace App\Services\Transaksi\Fuzzy;

class DurationEvaluator
{
    private const CEPAT = 6;
    private const NORMAL = 24;
    private const LAMA = 48;

    public function calculate(float $berat, int $jumlah, int $tingkatKekotoran, int $jumlahAntrean): int
    {
        $beban = $berat > 0 ? $berat : ($jumlah * 0.2);

        // Tahap A: Fuzzifikasi
        $muBeban = $this->fuzzifyBeban($beban);
        $muAntrean = $this->fuzzifyAntrean($jumlahAntrean);
        $muKekotoran = $this->fuzzifyKekotoran($tingkatKekotoran);

        // Tahap B: Evaluasi Rule & Implikasi (MIN/MAX)
        $rules = [];

        // R1: JIKA Antrean SEDIKIT & Beban RINGAN & Kekotoran RENDAH/SEDANG -> CEPAT
        $rules[] = [
            'w' => min($muAntrean['sedikit'], $muBeban['ringan'], max($muKekotoran['rendah'], $muKekotoran['sedang'])),
            'z' => self::CEPAT
        ];

        // R2: JIKA Antrean SEDIKIT & Beban SEDANG -> NORMAL
        $rules[] = [
            'w' => min($muAntrean['sedikit'], $muBeban['sedang']),
            'z' => self::NORMAL
        ];

        // R3: JIKA Antrean SEDIKIT & Beban BERAT -> NORMAL
        $rules[] = [
            'w' => min($muAntrean['sedikit'], $muBeban['berat']),
            'z' => self::NORMAL
        ];

        // R4: JIKA Antrean SEDANG & Beban RINGAN/SEDANG -> NORMAL
        $rules[] = [
            'w' => min($muAntrean['sedang'], max($muBeban['ringan'], $muBeban['sedang'])),
            'z' => self::NORMAL
        ];

        // R5: JIKA Antrean SEDANG & Beban BERAT -> LAMA
        $rules[] = [
            'w' => min($muAntrean['sedang'], $muBeban['berat']),
            'z' => self::LAMA
        ];

        // R6: JIKA Antrean BANYAK -> LAMA
        $rules[] = [
            'w' => $muAntrean['banyak'],
            'z' => self::LAMA
        ];

        // R7: JIKA Kekotoran TINGGI & Beban SEDANG/BERAT -> LAMA
        $rules[] = [
            'w' => min($muKekotoran['tinggi'], max($muBeban['sedang'], $muBeban['berat'])),
            'z' => self::LAMA
        ];

        // Tahap C: Defuzzifikasi
        return (int) round(FuzzyMath::defuzzifySugeno($rules, self::NORMAL));
    }

    private function fuzzifyBeban(float $x): array
    {
        return [
            'ringan' => FuzzyMath::linearTurun($x, 2, 5),
            'sedang' => FuzzyMath::segitiga($x, 3, 6, 9),
            'berat'  => FuzzyMath::linearNaik($x, 7, 12),
        ];
    }

    private function fuzzifyAntrean(int $x): array
    {
        // Limit ini tidak diubah karena yang dioper sekarang adalah 'Beban per Mesin'
        // Jadi batas 20 di bawah ini artinya "1 Mesin memegang 20 antrean sendirian" (Total 100 antrean di toko)
        return [
            'sedikit' => FuzzyMath::linearTurun($x, 3, 7),
            'sedang'  => FuzzyMath::segitiga($x, 5, 10, 15),
            'banyak'  => FuzzyMath::linearNaik($x, 12, 20),
        ];
    }

    private function fuzzifyKekotoran(int $x): array
    {
        return [
            'rendah' => FuzzyMath::linearTurun($x, 20, 50),
            'sedang' => FuzzyMath::segitiga($x, 35, 60, 85),
            'tinggi' => FuzzyMath::linearNaik($x, 70, 90),
        ];
    }
}
