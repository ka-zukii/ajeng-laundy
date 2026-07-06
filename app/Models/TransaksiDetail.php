<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
