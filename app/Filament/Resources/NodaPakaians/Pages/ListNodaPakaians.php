<?php

namespace App\Filament\Resources\NodaPakaians\Pages;

use App\Filament\Resources\NodaPakaians\NodaPakaianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNodaPakaians extends ListRecords
{
    protected static string $resource = NodaPakaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
