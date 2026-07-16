<?php

namespace App\Filament\Resources\NodaPakaians\Pages;

use App\Filament\Resources\NodaPakaians\NodaPakaianResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNodaPakaian extends EditRecord
{
    protected static string $resource = NodaPakaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
