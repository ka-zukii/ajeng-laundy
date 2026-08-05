<?php

namespace App\Services\Reservation;

use App\Enums\StatusReservation;
use App\Models\Pelanggan;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function create(array $data): Reservation
    {
        return DB::transaction(function () use ($data) {
            $pelanggan = Pelanggan::firstOrCreate([
                'nomor_telepon' => $data['whatsapp-number']
            ], [
                'nama' => $data['name'],
                'alamat' => $data['address']
            ]);

            $reservation = Reservation::create([
                'pelanggan_id' => $pelanggan->id,
                'layanan_id' => $data['layanan'],
                'tanggal_penjemputan' => $data['tanggal_penjemputan'],
                'status_reservation' => StatusReservation::MENUNGGU
            ]);

            return $reservation;
        });
    }
}
