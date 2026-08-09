<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Enums\StatusLaundry;
use App\Filament\Exports\TransaksiExporter;
use App\Filament\Resources\Transaksis\TransaksiResource;
use App\Models\Transaksi;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
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

    public function getTabs(): array
    {
        return [
            'Semua' => Tab::make()
                ->badge(Transaksi::count()),

            'Pending' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status_laundry', StatusLaundry::PENDING))
                ->badge(Transaksi::where('status_laundry', StatusLaundry::PENDING)->count())
                ->badgeColor('warning'),

            'Diproses' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status_laundry', StatusLaundry::DIPROSES))
                ->badge(Transaksi::where('status_laundry', StatusLaundry::DIPROSES)->count())
                ->badgeColor('info'),

            'Selesai' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->where('status_laundry', StatusLaundry::SELESAI))
                ->badge(Transaksi::where('status_laundry', StatusLaundry::SELESAI)->count())
                ->badgeColor('success'),
        ];
    }

    public function getTitle(): string
    {
        return 'Detail Transaksi';
    }
}
