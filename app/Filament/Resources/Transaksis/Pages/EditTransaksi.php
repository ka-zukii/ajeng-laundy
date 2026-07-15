<?php

namespace App\Filament\Resources\Transaksis\Pages;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\Transaksis\TransaksiResource;
use App\Services\Transaksi\TransactionService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTransaksi extends EditRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $detail = $this->record->transaksiDetail;

        if ($detail) {
            $data['layanan_id'] = $detail->layanan_id;
            $data['noda_pakaian_id'] = $detail->noda_pakaian_id;
            $data['tingkat_kekotoran'] = $detail->tingkat_kekotoran;
            $data['berat'] = $detail->berat;
            $data['jumlah'] = $detail->jumlah;
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return app(TransactionService::class)->update(
            $record->id,
            $data,
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Edit Transaksi Laundry';
    }
}
