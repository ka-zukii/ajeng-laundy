<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use App\Enums\JenisPerhitungan;
use App\Models\Layanan;
use App\Models\NodaPakaian;
use App\Models\Pelanggan;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
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
                Hidden::make('reservation_id')
                    ->default(request()->query('reservation_id'))
                    ->dehydrated(false),
                Section::make('Informasi Pelanggan')
                    ->description('Pilih pelanggan atau tambahkan pelanggan baru.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Select::make('pelanggan_id')
                            ->label('Pelanggan')
                            ->relationship('pelanggan', 'nomor_telepon')
                            ->searchable(['nama', 'nomor_telepon'])
                            ->preload()
                            ->live()
                            ->required()
                            ->prefixIcon('heroicon-m-user')
                            ->hint('Pilih pelanggan yang melakukan transaksi.')
                            ->default(request()->query('pelanggan_id'))
                            ->getOptionLabelFromRecordUsing(
                                fn(Pelanggan $record) => "{$record->nama} • {$record->nomor_telepon}"
                            )
                            ->createOptionForm([
                                TextInput::make('nama')
                                    ->label('Nama Lengkap')
                                    ->prefixIcon('heroicon-m-user')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('nomor_telepon')
                                    ->label('Nomor Telepon')
                                    ->tel()
                                    ->prefixIcon('heroicon-m-phone')
                                    ->required(),
                                Textarea::make('alamat')
                                    ->label('Alamat')
                                    ->rows(3)
                                    ->required(),
                            ])
                            ->afterStateUpdated(fn($state, callable $set) => self::fillCustomer($state, $set))
                            ->afterStateHydrated(fn($state, callable $set) => self::fillCustomer($state, $set)),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama_pelanggan')
                                    ->label('Nama')
                                    ->prefixIcon('heroicon-m-user')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->default(
                                        fn() => request()->has('pelanggan_id')
                                            ? Pelanggan::find(request()->query('pelanggan_id'))?->nama
                                            : null
                                    ),
                                TextInput::make('nomor_telepon')
                                    ->label('Nomor Telepon')
                                    ->prefixIcon('heroicon-m-phone')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->default(
                                        fn() => request()->has('pelanggan_id')
                                            ? Pelanggan::find(request()->query('pelanggan_id'))?->nomor_telepon
                                            : null
                                    ),
                                Textarea::make('alamat_pelanggan')
                                    ->label('Alamat')
                                    ->rows(3)
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->columnSpanFull()
                                    ->default(
                                        fn() => request()->has('pelanggan_id')
                                            ? Pelanggan::find(request()->query('pelanggan_id'))?->alamat
                                            : null
                                    ),
                            ]),
                    ]),
                Section::make('Detail Laundry')
                    ->description('Lengkapi detail laundry untuk menghitung biaya dan estimasi.')
                    ->icon('heroicon-o-archive-box')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('layanan_id')
                                    ->label('Layanan')
                                    ->relationship('transaksiDetail.layanan', 'nama_layanan')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->prefixIcon('heroicon-m-archive-box')
                                    ->hint('Pilih jenis layanan laundry.')
                                    ->default(request()->query('layanan_id')),
                                Select::make('noda_pakaian_id')
                                    ->label('Noda Pakaian')
                                    ->relationship('transaksiDetail.nodaPakaian', 'nama_noda')
                                    ->searchable()
                                    ->preload()
                                    ->prefixIcon('heroicon-m-beaker')
                                    ->hint('Pilih noda jika ada.')
                                    ->createOptionForm([
                                        TextInput::make('nama_noda')
                                            ->label('Nama Noda')
                                            ->required(),
                                        Textarea::make('solusi')
                                            ->label('Solusi')
                                            ->required(),
                                        TextInput::make('biaya_tambahan')
                                            ->label('Biaya Tambahan')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->required(),
                                    ])
                                    ->createOptionUsing(
                                        fn(array $data) => NodaPakaian::create($data)->id
                                    )
                                    ->required(),
                            ]),
                        Grid::make(12)
                            ->schema([
                                Slider::make('tingkat_kekotoran')
                                    ->label('Tingkat Kekotoran')
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->step(1)
                                    ->default(50)
                                    ->live()
                                    ->columnSpan(10)
                                    ->hint('0 = Sangat Bersih • 100 = Sangat Kotor'),
                                Placeholder::make('nilai')
                                    ->label('Nilai')
                                    ->content(fn(Get $get) => ($get('tingkat_kekotoran') ?? 0) . '%')
                                    ->columnSpan(2),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('berat')
                                    ->label('Berat')
                                    ->numeric()
                                    ->minValue(0.1)
                                    ->suffix('Kg')
                                    ->prefixIcon('heroicon-m-scale')
                                    ->placeholder('Contoh: 3.5')
                                    ->hint('Masukkan berat pakaian dalam kilogram.')
                                    ->visible(fn(Get $get) => self::isKiloan($get))
                                    ->required(fn(Get $get) => self::isKiloan($get)),
                                TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->minValue(1)
                                    ->suffix('Pcs')
                                    ->prefixIcon('heroicon-m-squares-2x2')
                                    ->placeholder('Contoh: 8')
                                    ->hint('Masukkan jumlah pakaian.')
                                    ->visible(fn(Get $get) => self::isSatuan($get))
                                    ->required(fn(Get $get) => self::isSatuan($get)),
                            ]),
                    ]),
            ]);
    }

    private static function fillCustomer($state, callable $set): void
    {
        $pelanggan = Pelanggan::find($state);

        if (! $pelanggan) {
            $set('nama_pelanggan', null);
            $set('nomor_telepon', null);
            $set('alamat_pelanggan', null);

            return;
        }

        $set('nama_pelanggan', $pelanggan->nama);
        $set('nomor_telepon', $pelanggan->nomor_telepon);
        $set('alamat_pelanggan', $pelanggan->alamat);
    }

    private static function isKiloan(Get $get): bool
    {
        $layanan = Layanan::find($get('layanan_id'));

        return $layanan?->jenis_perhitungan === JenisPerhitungan::KILOAN;
    }

    private static function isSatuan(Get $get): bool
    {
        $layanan = Layanan::find($get('layanan_id'));

        return $layanan?->jenis_perhitungan === JenisPerhitungan::SATUAN;
    }
}
