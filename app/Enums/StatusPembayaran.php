<?php

namespace App\Enums;

enum StatusPembayaran: string
{
    case SUKSES = 'sukses';
    case MENGUNGGU = 'menunggu';
    case DIBATALKAN = 'dibatalkan';

    public function label(): string
    {
        return match ($this) {
            self::SUKSES => 'Sukses',
            self::MENGUNGGU => 'Menunggu',
            self::DIBATALKAN => 'Dibatalkan'
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn(self $statusPembayaran) => [
            $statusPembayaran->value => $statusPembayaran->label()
        ])->toArray();
    }
}
