<?php

namespace App\Enums;

use Carbon\Carbon;

enum TipeLayanan: string
{
    case EXPRESS = 'express';
    case ONEDAY = 'one_day';
    case QUICK = 'quick';
    case REGULAR = 'regular';

    public function label(): string
    {
        return match ($this) {
            self::EXPRESS => 'Express',
            self::ONEDAY => 'One Day',
            self::QUICK => 'Quick',
            self::REGULAR => 'Regular'
        };
    }

    public function estimatedCompletion(Carbon $dateEntry = new Carbon()): Carbon
    {
        return match ($this) {
            self::EXPRESS => $dateEntry->copy()->addHours(6),
            self::ONEDAY  => $dateEntry->copy()->addDay(),
            self::QUICK   => $dateEntry->copy()->addHours(3),
            self::REGULAR => $dateEntry->copy()->addDays(3),
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn(self $tipeLayanan) => [
            $tipeLayanan->value => $tipeLayanan->label()
        ])->toArray();
    }
}
