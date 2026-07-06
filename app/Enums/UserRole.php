<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case KARYAWAN = 'karyawan';
    case PELANGGAN = 'pelanggan';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::KARYAWAN => 'Karyawan',
            self::PELANGGAN => 'Pelanggan'
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn(self $role) => [
            $role->value => $role->label()
        ])->toArray();
    }
}
