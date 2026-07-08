<?php

namespace App\Enums;

enum TipeLayanan: string
{
    case EXPRESS = 'express';
    case ONEDAY = 'one_day';
    case QUICK = 'quick';
    case REGULAR = 'regular';

    public function label(): string
    {
        return match ($this) {
            self::EXPRESS => 'express',
            self::ONEDAY => 'one_day',
            self::QUICK => 'quick',
            self::REGULAR => 'regular'
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn(self $tipeLayanan) => [
            $tipeLayanan->value => $tipeLayanan->label()
        ])->toArray();
    }
}
