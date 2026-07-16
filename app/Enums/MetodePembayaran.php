<?php

namespace App\Enums;

enum MetodePembayaran: string
{
    // Manual
    case TUNAI = 'tunai';

    // QRIS
    case QRIS = 'qris';

    // Virtual Account
    case BANK_TRANSFER = 'bank_transfer';

    // E-Wallet
    case GOPAY = 'gopay';
    case SHOPEEPAY = 'shopeepay';

    // Kartu
    case CREDIT_CARD = 'credit_card';

    public function label(): string
    {
        return match ($this) {
            self::TUNAI => 'Tunai',
            self::QRIS => 'QRIS',
            self::BANK_TRANSFER => 'Transfer Bank (VA)',
            self::GOPAY => 'GoPay',
            self::SHOPEEPAY => 'ShopeePay',
            self::CREDIT_CARD => 'Kartu Kredit',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TUNAI => 'gray',
            self::QRIS => 'success',
            self::BANK_TRANSFER => 'info',
            self::GOPAY => 'success',
            self::SHOPEEPAY => 'warning',
            self::CREDIT_CARD => 'primary',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $item) => [
                $item->value => $item->label(),
            ])
            ->toArray();
    }
}
