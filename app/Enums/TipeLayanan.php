<?php

namespace App\Enums;

enum TipeLayanan: string
{
    case DAILYKILOAN = 'daily_kiloan';
    case DAILYSATUAN = 'daily_satuan';
    case SETRIKAKILOAN = 'setrika_kiloan';

    public function label(): string
    {
        return match ($this) {
            self::DAILYKILOAN => 'Daily Kiloan',
            self::DAILYSATUAN => 'Daily Satuan',
            self::SETRIKAKILOAN => 'Setrika Kiloan'
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn(self $tipeLayanan) => [
            $tipeLayanan->value => $tipeLayanan->label()
        ])->toArray();
    }
}
