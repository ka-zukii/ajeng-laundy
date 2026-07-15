<?php

namespace App\Services\Transaksi;

use App\Models\Transaksi;
use Illuminate\Support\Str;

class TransactionCodeService
{
    public function generate(): string
    {
        do {
            $code = sprintf(
                'AJL-%s-%s',
                now()->format('Ymd'),
                Str::upper(Str::random(6))
            );
        } while (Transaksi::where('kode_transaksi', $code)->exists());

        return $code;
    }
}
