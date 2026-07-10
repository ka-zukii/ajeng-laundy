<?php

namespace App\Filament\Resources\PenyakitNodas\Pages;

use App\Filament\Resources\PenyakitNodas\PenyakitNodaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenyakitNodas extends ListRecords
{
    protected static string $resource = PenyakitNodaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
