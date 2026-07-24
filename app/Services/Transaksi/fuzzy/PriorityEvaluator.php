<?php

namespace App\Services\Transaksi\Fuzzy;

use App\Enums\PrioritasLaundry;

class PriorityEvaluator
{
    private const RENDAH = 1.0;
    private const SEDANG = 2.0;
    private const TINGGI = 3.0;

    public function calculate(int $tingkatKekotoran, int $lamaMenunggu): PrioritasLaundry
    {
        // Tahap A: Fuzzifikasi
        $muKekotoran = $this->fuzzifyKekotoran($tingkatKekotoran);
        $muMenunggu = $this->fuzzifyWaktuTunggu($lamaMenunggu);

        // Tahap B: Evaluasi Rule
        $rules = [];

        // R1: JIKA Waktu Tunggu LAMA -> TINGGI (Prioritas Mutlak)
        $rules[] = [
            'w' => $muMenunggu['lama'],
            'z' => self::TINGGI
        ];

        // R2: JIKA Waktu Tunggu SEDANG & Kekotoran TINGGI -> TINGGI 
        $rules[] = [
            'w' => min($muMenunggu['sedang'], $muKekotoran['tinggi']),
            'z' => self::TINGGI
        ];

        // R3: JIKA Waktu Tunggu SEDANG & Kekotoran RENDAH/SEDANG -> SEDANG
        $rules[] = [
            'w' => min($muMenunggu['sedang'], max($muKekotoran['rendah'], $muKekotoran['sedang'])),
            'z' => self::SEDANG
        ];

        // R4: JIKA Waktu Tunggu BARU & Kekotoran TINGGI -> SEDANG (Baru masuk tapi bajunya kotor banget)
        $rules[] = [
            'w' => min($muMenunggu['baru'], $muKekotoran['tinggi']),
            'z' => self::SEDANG
        ];

        // R5: JIKA Waktu Tunggu BARU & Kekotoran RENDAH/SEDANG -> RENDAH
        $rules[] = [
            'w' => min($muMenunggu['baru'], max($muKekotoran['rendah'], $muKekotoran['sedang'])),
            'z' => self::RENDAH
        ];

        // Tahap C: Defuzzifikasi
        $skalaPrioritas = FuzzyMath::defuzzifySugeno($rules, self::RENDAH);

        // Konversi
        return $this->resolveEnum($skalaPrioritas);
    }

    private function resolveEnum(float $skalaPrioritas): PrioritasLaundry
    {
        if ($skalaPrioritas >= 2.5) {
            return PrioritasLaundry::HIGH;
        }
        if ($skalaPrioritas >= 1.5) {
            return PrioritasLaundry::MEDIUM;
        }
        return PrioritasLaundry::LOW;
    }

    private function fuzzifyKekotoran(int $x): array
    {
        return [
            'rendah' => FuzzyMath::linearTurun($x, 20, 50),
            'sedang' => FuzzyMath::segitiga($x, 35, 60, 85),
            'tinggi' => FuzzyMath::linearNaik($x, 70, 90),
        ];
    }

    private function fuzzifyWaktuTunggu(int $x): array
    {
        // Asumsi dalam jam
        return [
            'baru'   => FuzzyMath::linearTurun($x, 2, 8),
            'sedang' => FuzzyMath::segitiga($x, 5, 12, 18),
            'lama'   => FuzzyMath::linearNaik($x, 15, 24),
        ];
    }
}
