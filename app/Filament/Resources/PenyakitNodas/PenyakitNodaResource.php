<?php

namespace App\Filament\Resources\PenyakitNodas;

use App\Filament\Resources\PenyakitNodas\Pages\CreatePenyakitNoda;
use App\Filament\Resources\PenyakitNodas\Pages\EditPenyakitNoda;
use App\Filament\Resources\PenyakitNodas\Pages\ListPenyakitNodas;
use App\Filament\Resources\PenyakitNodas\Schemas\PenyakitNodaForm;
use App\Filament\Resources\PenyakitNodas\Tables\PenyakitNodasTable;
use App\Models\PenyakitNoda;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PenyakitNodaResource extends Resource
{
    protected static ?string $model = PenyakitNoda::class;

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Penyakit Noda';
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ExclamationTriangle;

    public static function form(Schema $schema): Schema
    {
        return PenyakitNodaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenyakitNodasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenyakitNodas::route('/'),
            'create' => CreatePenyakitNoda::route('/create'),
            'edit' => EditPenyakitNoda::route('/{record}/edit'),
        ];
    }
}
