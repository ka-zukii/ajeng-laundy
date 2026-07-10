<?php

namespace App\Filament\Resources\PenyakitNodas\Pages;

use App\Filament\Resources\PenyakitNodas\PenyakitNodaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPenyakitNoda extends EditRecord
{
    protected static string $resource = PenyakitNodaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
