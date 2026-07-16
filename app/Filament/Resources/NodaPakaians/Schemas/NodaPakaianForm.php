<?php

namespace App\Filament\Resources\NodaPakaians\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class NodaPakaianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Noda')
                    ->description('Masukkan informasi mengenai jenis noda pakaian.')
                    ->icon(Heroicon::Sparkles)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama_noda')
                                    ->label('Nama Noda')
                                    ->placeholder('Contoh: Noda Kopi')
                                    ->required()
                                    ->maxLength(100)
                                    ->columnSpanFull(),
                                TextInput::make('biaya_tambahan')
                                    ->label('Biaya Tambahan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->default(0)
                                    ->placeholder('0')
                                    ->required(),
                            ]),
                        Textarea::make('solusi')
                            ->label('Solusi Penanganan')
                            ->placeholder(
                                'Contoh: Rendam menggunakan cairan khusus selama 15 menit sebelum proses pencucian.'
                            )
                            ->rows(5)
                            ->columnSpanFull(),

                    ]),
            ]);
    }
}
