<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
