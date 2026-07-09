<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'nama_penyakit',
    'solusi',
    'biaya_tambahan',
])]
class PenyakitNoda extends Model
{
    protected $table = 'penyakit_noda';

    public function rule(): HasMany
    {
        return $this->hasMany(Rule::class);
    }

    public function transaksiDetail(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
