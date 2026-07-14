<?php

namespace App\Enums;

enum UserRole: string
{
    case OWNER = 'owner';
    case KARYAWAN = 'karyawan';
    case PELANGGAN = 'pelanggan';

    public function label(): string
    {
        return match ($this) {
            self::OWNER => 'Owner',
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

    public function color(): string
    {
        return match ($this) {
            self::OWNER => 'danger',
            self::KARYAWAN => 'warning',
            self::PELANGGAN => 'success'
        };
    }
}
