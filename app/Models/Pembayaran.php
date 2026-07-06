<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
