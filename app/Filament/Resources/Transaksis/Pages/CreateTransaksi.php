<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use App\Services\TransaksiService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return app(TransaksiService::class)->create($data);
    }

    public function getTitle(): string
    {
        return 'Tambah Transaksi Laundry';
    }
}
