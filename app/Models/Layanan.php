<?php

namespace App\Models;

use App\Enums\TipeLayanan;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

#[Fillable([
    'nama_layanan',
    'tipe_layanan',
    'biaya_layanan',
])]
class Layanan extends Model
{
    protected $table = 'layanan';

    public function casts(): array
    {
        return [
            'tipe_layanan' => TipeLayanan::class
        ];
    }

    public function transaksiDetail(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
