<?php

namespace App\Models;

use App\Enums\StatusLaundry;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'users_id',
    'kode_transaksi',
    'tanggal_masuk',
    'tanggal_selesai',
    'status_laundry',
    'total_biaya',
])]
class Transaksi extends Model
{
    protected $table = 'transaksi';

    public function casts(): array
    {
        return [
            'status_laundry' => StatusLaundry::class
        ];
    }

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
