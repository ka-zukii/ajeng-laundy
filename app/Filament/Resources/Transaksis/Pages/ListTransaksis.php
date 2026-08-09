<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Exports\TransaksiExporter;
use App\Filament\Resources\Transaksis\TransaksiResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(TransaksiExporter::class)
                ->label('Export Excel')
                ->color('success')
                ->icon(Heroicon::DocumentArrowDown),
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Detail Transaksi';
    }
}
