<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'transaksi_id',
    'layanan_id',
    'noda_pakaian_id',
    'berat',
    'jumlah',
    'tingkat_kekotoran'
])]
class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    public function nodaPakaian(): BelongsTo
    {
        return $this->belongsTo(NodaPakaian::class);
    }
}
