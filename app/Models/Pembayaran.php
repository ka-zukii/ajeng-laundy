<?php

namespace App\Models;

use App\Enums\StatusPembayaran;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

#[Fillable([
    'transaksi_id',
    'metode_pembayaran',
    'tanggal_pembayaran',
    'jumlah_pembayaran',
    'status_pembayaran',
])]
class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    public function casts(): array
    {
        return [
            'status_pembayaran' => StatusPembayaran::class
        ];
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }
}
