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
            self::SUKSES => 'Pembayaran Berhasil',
            self::MENGUNGGU => 'Menunggu Pembayaran',
            self::DIBATALKAN => 'Pembayaran Dibatalkan'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUKSES => 'success',
            self::MENGUNGGU => 'warning',
            self::DIBATALKAN => 'danger'
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn(self $statusPembayaran) => [
            $statusPembayaran->value => $statusPembayaran->label()
        ])->toArray();
    }
}
