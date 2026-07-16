<?php

namespace App\Models;

use App\Enums\MetodePembayaran;
use App\Enums\StatusPembayaran;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'transaksi_id',

    'jumlah_pembayaran',

    'metode_pembayaran',
    'payment_gateway',

    'status_pembayaran',
    'tanggal_pembayaran',

    // Midtrans
    'snap_token',
    'payment_type',
    'bank',
    'va_number',
    'midtrans_transaction_id',
    'expired_at',

    'catatan',
])]
class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected function casts(): array
    {
        return [
            'status_pembayaran' => StatusPembayaran::class,
            'metode_pembayaran' => MetodePembayaran::class,
            'jumlah_pembayaran' => 'decimal:2',
            'tanggal_pembayaran' => 'datetime',
            'expired_at' => 'datetime',
        ];
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function isPaid(): bool
    {
        return $this->status_pembayaran === StatusPembayaran::SUKSES;
    }

    public function isPending(): bool
    {
        return $this->status_pembayaran === StatusPembayaran::MENGUNGGU;
    }

    public function isCancelled(): bool
    {
        return $this->status_pembayaran === StatusPembayaran::DIBATALKAN;
    }
}
