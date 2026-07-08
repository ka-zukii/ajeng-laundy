<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = [
        'transaksi_id',
        'metode_pembayaran',
        'tanggal_pembayaran',
        'jumlah_pembayaran',
        'status_pembayaran',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }
}
