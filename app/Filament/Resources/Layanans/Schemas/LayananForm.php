<?php

namespace App\Filament\Resources\Layanans\Schemas;

use App\Enums\JenisPerhitungan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class LayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Layanan')
                    ->description('Lengkapi informasi layanan laundry.')
                    ->icon(Heroicon::Sparkles)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama_layanan')
                                    ->label('Nama Layanan')
                                    ->placeholder('Contoh: Daily Kiloan')
                                    ->required()
                                    ->maxLength(100)
                                    ->columnSpanFull(),
                                Select::make('jenis_perhitungan')
                                    ->label('Jenis Perhitungan')
                                    ->options(JenisPerhitungan::options())
                                    ->native(false)
                                    ->searchable()
                                    ->required()
                                    ->helperText(
                                        'Pilih apakah layanan dihitung berdasarkan kilogram atau jumlah satuan.'
                                    ),
                                TextInput::make('biaya_layanan')
                                    ->label('Biaya Layanan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->default(0)
                                    ->required()
                                    ->placeholder('Masukkan biaya layanan'),
                            ]),
                    ]),
            ]);
    }
}
