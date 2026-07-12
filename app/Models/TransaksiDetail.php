<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'transaksi_id',
    'layanan_id',
    'penyakit_noda_id',
    'berat',
    'jumlah',
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

    public function penyakitNoda(): BelongsTo
    {
        return $this->belongsTo(PenyakitNoda::class);
    }
}
