<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)
                    ->components([
                        Select::make('pelanggan_id')
                            ->relationship('pelanggan', 'nama')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('nama')->label('Nama Lengkap')->required(),
                                TextInput::make('nomor_telepon')->label('Nomor Telepon')->required(),
                                Textarea::make('alamat')->label('Alamat')->required(),
                            ])
                            ->label('Pelanggan'),
                    ]),
                Section::make('Detail Laundry')
                    ->relationship('transaksiDetail')
                    ->schema([
                        Select::make('layanan_id')
                            ->relationship('layanan', 'nama_layanan')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('penyakit_noda_id')
                            ->relationship('penyakitNoda', 'nama_penyakit')
                            ->searchable()
                            ->preload(),

                        TextInput::make('berat')
                            ->label('Berat (kg)')
                            ->numeric()
                            ->suffix('kg'),

                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric(),
                    ])
            ]);
    }
}
