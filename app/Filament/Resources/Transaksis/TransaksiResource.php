<?php

namespace App\Filament\Resources\Transaksis;

use App\Filament\Resources\Transaksis\Pages\CreateTransaksi;
use App\Filament\Resources\Transaksis\Pages\EditTransaksi;
use App\Filament\Resources\Transaksis\Pages\ListTransaksis;
use App\Filament\Resources\Transaksis\Schemas\TransaksiForm;
use App\Filament\Resources\Transaksis\Tables\TransaksisTable;
use App\Models\Transaksi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Transaksi';
    protected static string|UnitEnum|null $navigationGroup = 'Transaksi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ReceiptPercent;

    public static function getBreadcrumb(): string
    {
        return 'Transaksi Laundry';
    }
    public static function form(Schema $schema): Schema
    {
        return TransaksiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransaksisTable::configure($table);
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
            ->with([
                'pelanggan',
                'transaksiDetail',
                'transaksiDetail.layanan',
                'transaksiDetail.nodaPakaian',
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransaksis::route('/'),
            'create' => CreateTransaksi::route('/create'),
            'edit' => EditTransaksi::route('/{record}/edit'),
        ];
    }
}
