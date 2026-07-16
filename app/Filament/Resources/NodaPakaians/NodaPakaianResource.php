<?php

namespace App\Filament\Resources\NodaPakaians;

use App\Filament\Resources\NodaPakaians\Pages\CreateNodaPakaian;
use App\Filament\Resources\NodaPakaians\Pages\EditNodaPakaian;
use App\Filament\Resources\NodaPakaians\Pages\ListNodaPakaians;
use App\Filament\Resources\NodaPakaians\Schemas\NodaPakaianForm;
use App\Filament\Resources\NodaPakaians\Tables\NodaPakaiansTable;
use App\Models\NodaPakaian;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NodaPakaianResource extends Resource
{
    protected static ?string $model = NodaPakaian::class;

    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Noda Pakaian';
        protected static string|UnitEnum|null $navigationGroup = 'Master Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookmarkSquare;
    protected static ?string $recordTitleAttribute = 'Noda Pakaian';

    public static function getBreadcrumb(): string
    {
        return 'Noda Pakaian';
    }

    public static function form(Schema $schema): Schema
    {
        return NodaPakaianForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NodaPakaiansTable::configure($table);
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
            'index' => ListNodaPakaians::route('/'),
            'create' => CreateNodaPakaian::route('/create'),
            'edit' => EditNodaPakaian::route('/{record}/edit'),
        ];
    }
}
