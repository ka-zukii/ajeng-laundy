<?php

namespace App\Enums;

enum StatusReservation: string
{
    case DIJADWALKAN = 'dijadwalkan';
    case MENUNGGU = 'menunggu';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';

    public function label(): string
    {
        return match ($this) {
            self::DIJADWALKAN => 'Dijadwalkan',
            self::MENUNGGU => 'Menunggu Penjemputan',
            self::SELESAI => 'Selesai',
            self::DIBATALKAN => 'Dibatalkan',
        };
    }

    public function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $item) => [
                $item->value => $item->label(),
            ])
            ->toArray();
    }
}
