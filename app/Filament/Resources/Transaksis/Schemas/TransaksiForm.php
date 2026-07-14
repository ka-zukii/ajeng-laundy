<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use App\Enums\JenisPerhitungan;
use App\Models\User;
use App\Models\PenyakitNoda;
use App\Models\Layanan;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Informasi Pelanggan")
                    ->description('Tambahkan informasi pelanggan.')
                    ->schema([
                        Select::make('pelanggan_id')
                            ->label('Pelanggan')
                            ->relationship('pelanggan', 'nomor_telepon')
                            ->searchable(['nama', 'nomor_telepon'])
                            ->getOptionLabelFromRecordUsing(
                                fn($record) => "{$record->nama} • {$record->nomor_telepon}"
                            )
                            ->preload()
                            ->live()
                            ->createOptionForm([
                                TextInput::make('nama')
                                    ->label('Nama Lengkap')
                                    ->required(),

                                TextInput::make('nomor_telepon')
                                    ->label('Nomor Telepon')
                                    ->required(),

                                Textarea::make('alamat')
                                    ->label('Alamat')
                                    ->required(),
                            ])
                            ->afterStateUpdated(function ($state, callable $set) {
                                $pelanggan = \App\Models\Pelanggan::find($state);

                                if (! $pelanggan) {
                                    return;
                                }

                                $set('nama_pelanggan', $pelanggan->nama);
                                $set('nomor_telepon', $pelanggan->nomor_telepon);
                                $set('alamat_pelanggan', $pelanggan->alamat);
                            })
                            ->afterStateHydrated(function ($state, callable $set) {
                                $pelanggan = \App\Models\Pelanggan::find($state);

                                if (! $pelanggan) {
                                    return;
                                }

                                $set('nama_pelanggan', $pelanggan->nama);
                                $set('nomor_telepon', $pelanggan->nomor_telepon);
                                $set('alamat_pelanggan', $pelanggan->alamat);
                            }),

                        Grid::make(3)
                            ->schema([

                                TextInput::make('nama_pelanggan')
                                    ->label('Nama')
                                    ->disabled()
                                    ->dehydrated(false),

                                TextInput::make('nomor_telepon')
                                    ->label('Nomor Telepon')
                                    ->disabled()
                                    ->dehydrated(false),

                                Textarea::make('alamat_pelanggan')
                                    ->label('Alamat')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->columnSpanFull(),

                            ]),
                    ]),
                Section::make('Detail Laundry')
                    ->description('Masukkan detail layanan laundry.')
                    ->schema([
                        Select::make('layanan_id')
                            ->label("Layanan")
                            ->options(Layanan::options())
                            ->searchable()
                            ->required()
                            ->live(),

                        Select::make('penyakit_noda_id')
                            ->label('Penyakit Noda')
                            ->options(PenyakitNoda::options())
                            ->searchable(),

                        TextInput::make('berat')
                            ->visible(function (Get $get) {

                                $layanan = Layanan::find($get('layanan_id'));

                                return $layanan?->jenis_perhitungan === JenisPerhitungan::KILOAN;
                            }),

                        TextInput::make('jumlah')
                            ->visible(function (Get $get) {

                                $layanan = Layanan::find($get('layanan_id'));

                                return $layanan?->jenis_perhitungan === JenisPerhitungan::SATUAN;
                            }),
                    ])
            ]);
    }
}
