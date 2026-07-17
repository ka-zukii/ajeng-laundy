<?php

namespace App\Models;

use App\Enums\PrioritasLaundry;
use App\Enums\StatusLaundry;
use App\Services\Transaksi\TransactionCodeService;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'pelanggan_id',
    'kode_transaksi',
    'tanggal_masuk',
    'tanggal_selesai',
    'estimasi_selesai',
    'status_laundry',
    'prioritas',
    'total_biaya',
])]
class Transaksi extends Model
{
    protected $table = 'transaksi';

    public function casts(): array
    {
        return [
            'estimasi_selesai' => 'datetime',
            'status_laundry' => StatusLaundry::class,
            'prioritas' => PrioritasLaundry::class,
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Transaksi $transaksi) {
            $transaksi->kode_transaksi = app(TransactionCodeService::class)
                ->generate();
        });
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
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
