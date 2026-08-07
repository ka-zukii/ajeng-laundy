<?php

namespace App\Models;

use App\Enums\StatusReservation;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'pelanggan_id',
    'layanan_id',
    'transaksi_id',
    'tanggal_penjemputan',
    'status_reservation',
])]
class Reservation extends Model
{
    protected $table = 'reservation';

    protected function casts(): array
    {
        return [
            'status_reservation' => StatusReservation::class,
        ];
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
