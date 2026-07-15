<?php

namespace App\Enums;

enum PrioritasLaundry: string
{
    case HIGH = 'HIGH';
    case MEDIUM = 'MEDIUM';
    case LOW = 'LOW';

    public function label(): string
    {
        return match ($this) {
            self::HIGH => 'High',
            self::MEDIUM => 'Medium',
            self::LOW => 'Low',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::HIGH => 'danger',
            self::MEDIUM => 'warning',
            self::LOW => 'success',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn(self $prioritas) => [
            $prioritas->value => $prioritas->label(),
        ])->toArray();
    }
}