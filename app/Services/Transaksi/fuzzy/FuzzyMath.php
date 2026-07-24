<?php

namespace App\Services\Transaksi\Fuzzy;

class FuzzyMath
{
    public static function linearTurun(float $x, float $a, float $b): float
    {
        if ($x <= $a) return 1.0;
        if ($x >= $b) return 0.0;
        return ($b - $x) / ($b - $a);
    }

    public static function linearNaik(float $x, float $a, float $b): float
    {
        if ($x <= $a) return 0.0;
        if ($x >= $b) return 1.0;
        return ($x - $a) / ($b - $a);
    }

    public static function segitiga(float $x, float $a, float $b, float $c): float
    {
        if ($x <= $a || $x >= $c) return 0.0;
        if ($x == $b) return 1.0;
        if ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
        return ($c - $x) / ($c - $b);
    }

    public static function defuzzifySugeno(array $rules, float $default): float
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
}
