<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';
    protected $fillable = [
        'transaksi_id',
        'layanan_id',
        'penyakit_id',
        'penyakit_noda_id',
        'berat',
        'jumlah',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function penyakitNoda(): BelongsTo
    {
        return $this->belongsTo(PenyakitNoda::class);
    }
}
