<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    protected $table = 'layanan';
    protected $fillable = [
        'nama_layanan',
        'tipe_layanan',
        'biaya_layanan',
    ];

    public function transaksiDetail(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
