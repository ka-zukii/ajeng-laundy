<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Enums\StatusReservation;
use App\Filament\Resources\Transaksis\TransaksiResource;
use App\Models\Reservation;
use App\Services\Transaksi\TransactionService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return app(TransactionService::class)->create($data);
    }

    public function getTitle(): string
    {
        return 'Tambah Transaksi Laundry';
    }

    public function afterCreate(): void
    {
        $data = $this->form->getRawState();
        $reservationId = $data['reservation_id'] ?? null;

        if ($reservationId) {
            $reservation = Reservation::find($reservationId);

            if ($reservation) {
                $reservation->update([
                    'status_reservation' => StatusReservation::SELESAI,
                    'transaksi_id' => $this->record->id,
                ]);
            }
        }
    }
}
