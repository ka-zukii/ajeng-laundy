<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }
}
