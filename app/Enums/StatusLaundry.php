<?php

namespace App\Enums;

enum StatusLaundry: string
{
    case SELESAI = 'selesai';
    case DIPROSES = 'diproses';
    case PENDING = 'pending';

    public function label(): string
    {
        return match ($this) {
            self::SELESAI => 'Selesai',
            self::DIPROSES => 'Diproses',
            self::PENDING => 'Pending',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SELESAI => 'success',
            self::DIPROSES => 'info',
            self::PENDING => 'warning',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [
                $status->value => $status->label(),
            ])
            ->toArray();
    }
}