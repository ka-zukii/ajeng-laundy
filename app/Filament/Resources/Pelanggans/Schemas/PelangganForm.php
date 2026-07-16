<?php

namespace App\Filament\Resources\Pelanggans\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class PelangganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pelanggan')
                    ->description('Lengkapi data pelanggan yang akan menggunakan layanan laundry.')
                    ->icon(Heroicon::UserCircle)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama')
                                    ->label('Nama Lengkap')
                                    ->placeholder('Contoh: Rizky Andika')
                                    ->required()
                                    ->maxLength(100)
                                    ->columnSpanFull(),
                                TextInput::make('nomor_telepon')
                                    ->label('Nomor Telepon')
                                    ->tel()
                                    ->placeholder('08xxxxxxxxxx')
                                    ->required()
                                    ->maxLength(20)
                                    ->helperText('Nomor telepon digunakan untuk mencari data pelanggan saat membuat transaksi.')
                                    ->unique(
                                        table: 'pelanggan',
                                        column: 'nomor_telepon',
                                        ignoreRecord: true,
                                    ),
                                TextInput::make('user.email')
                                    ->label('Email Akun')
                                    ->email()
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->placeholder('Belum memiliki akun')
                                    ->helperText('Akan terisi apabila pelanggan telah mendaftarkan akun.'),
                            ]),
                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->placeholder('Masukkan alamat lengkap pelanggan...')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
