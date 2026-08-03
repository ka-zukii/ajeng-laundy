<?php

namespace App\Services\Reservation;

use App\Models\Reservation;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function create(array $data): Reservation
    {
        return DB::transaction(function () use ($data) {
            $transaksi = Transaksi::create([]);

            $reservation = $transaksi->reservation()->create([]);

            return $reservation;
        });
    }
}
