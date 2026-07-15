<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'nama_noda',
    'solusi',
    'biaya_tambahan',
])]
class NodaPakaian extends Model
{
    protected $table = 'noda_pakaian';

    public static function options(): array
    {
        return static::pluck('nama_noda', 'id')
            ->toArray();
    }

    public function transaksiDetail(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
