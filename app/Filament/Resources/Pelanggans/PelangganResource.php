<?php

namespace App\Filament\Resources\Pelanggans;

use App\Filament\Resources\Pelanggans\Pages\CreatePelanggan;
use App\Filament\Resources\Pelanggans\Pages\EditPelanggan;
use App\Filament\Resources\Pelanggans\Pages\ListPelanggans;
use App\Filament\Resources\Pelanggans\Schemas\PelangganForm;
use App\Filament\Resources\Pelanggans\Tables\PelanggansTable;
use App\Models\Pelanggan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Pelanggan';
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Pelanggan';

    public static function getBreadcrumb(): string
    {
        return 'Pelanggan';
    }

    public static function form(Schema $schema): Schema
    {
        return PelangganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PelanggansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('transaksi')
            ->withSum('transaksi', 'total_biaya')
            ->withMax('transaksi', 'tanggal_masuk');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPelanggans::route('/'),
            'create' => CreatePelanggan::route('/create'),
            'edit' => EditPelanggan::route('/{record}/edit'),
        ];
    }
}
