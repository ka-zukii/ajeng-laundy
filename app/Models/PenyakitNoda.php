<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenyakitNoda extends Model
{
    protected $table = 'penyakit_noda';
    protected $fillable = [
        'nama_penyakit',
        'solusi',
        'biaya_tambahan',
    ];

    public function rule(): HasMany
    {
        return $this->hasMany(Rule::class);
    }

    public function transaksiDetail(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
