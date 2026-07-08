<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
        'users_id',
        'kode_transaksi',
        'tanggal_masuk',
        'tanggal_selesai',
        'status_laundry',
        'total_biaya',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaksiDetail(): HasOne
    {
        return $this->hasOne(TransaksiDetail::class);
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class);
    }
}
