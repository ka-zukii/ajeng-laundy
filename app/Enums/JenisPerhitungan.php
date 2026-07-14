<?php

namespace App\Enums;

enum JenisPerhitungan: string
{
    case KILOAN = 'kiloan';
    case SATUAN = 'satuan';

    public function label(): string
    {
        return match ($this) {
            self::KILOAN => 'Kiloan',
            self::SATUAN => 'Satuan',
        };
    }

    public function suffix(): string
    {
        return match ($this) {
            self::KILOAN => 'Kg',
            self::SATUAN => 'Item',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $jenis) => [
                $jenis->value => $jenis->label(),
            ])
            ->toArray();
    }
}
