<?php

namespace App\Models;

use App\Enums\JenisPerhitungan;
use App\Enums\TipeLayanan;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

#[Fillable([
    'nama_layanan',
    'tipe_layanan',
    'jenis_perhitungan',
    'biaya_layanan',
])]
class Layanan extends Model
{
    protected $table = 'layanan';

    public function casts(): array
    {
        return [
            'tipe_layanan' => TipeLayanan::class,
            'jenis_perhitungan' => JenisPerhitungan::class
        ];
    }

    public static function options(): array
    {
        return static::query()
            ->get()
            ->mapWithKeys(fn(self $layanan) => [
                $layanan->id =>
                "{$layanan->nama_layanan} • {$layanan->tipe_layanan->label()}",
            ])
            ->toArray();
    }

    public function transaksiDetail(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
