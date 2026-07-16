<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->description('Masukkan informasi dasar akun pengguna.')
                    ->icon(Heroicon::UserCircle)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('username')
                                    ->label('Username')
                                    ->placeholder('Contoh: rizkyandika')
                                    ->required()
                                    ->unique(
                                        table: 'users',
                                        ignoreRecord: true,
                                    )
                                    ->maxLength(50)
                                    ->prefixIcon(Heroicon::User),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->placeholder('Contoh: rizky@gmail.com')
                                    ->unique(
                                        table: 'users',
                                        ignoreRecord: true,
                                    )
                                    ->maxLength(255)
                                    ->prefixIcon(Heroicon::Envelope),
                                TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->revealable()
                                    ->required(fn(string $operation) => $operation === 'create')
                                    ->dehydrated(fn($state) => filled($state))
                                    ->placeholder(
                                        fn(string $operation) =>
                                        $operation === 'create'
                                            ? 'Masukkan password'
                                            : 'Kosongkan jika tidak ingin mengubah password'
                                    )
                                    ->columnSpanFull()
                                    ->helperText('Minimal gunakan kombinasi huruf dan angka.'),
                            ]),
                    ]),
                Section::make('Hak Akses')
                    ->description('Atur role dan hubungkan akun dengan data pelanggan.')
                    ->icon(Heroicon::ShieldCheck)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('role')
                                    ->label('Role Pengguna')
                                    ->options(UserRole::options())
                                    ->required()
                                    ->native(false)
                                    ->default(UserRole::PELANGGAN->value)
                                    ->helperText('Role menentukan hak akses pengguna pada sistem.'),
                                Select::make('pelanggan_id')
                                    ->label('Data Pelanggan')
                                    ->relationship(
                                        name: 'pelanggan',
                                        titleAttribute: 'nomor_telepon',
                                    )
                                    ->searchable(['nama', 'nomor_telepon'])
                                    ->preload()
                                    ->native(false)
                                    ->placeholder('Belum dihubungkan')
                                    ->getOptionLabelFromRecordUsing(
                                        fn($record) => "{$record->nama} • {$record->nomor_telepon}"
                                    )
                                    ->helperText(
                                        'Hubungkan akun ini dengan pelanggan yang sudah terdaftar agar pelanggan dapat melihat riwayat transaksinya.'
                                    ),
                            ]),
                        Placeholder::make('informasi')
                            ->hidden(fn(string $operation) => $operation === 'create')
                            ->label('Informasi')
                            ->content('Apabila akun sudah terhubung dengan pelanggan, pelanggan dapat login dan melihat status transaksi laundry secara langsung.'),
                    ]),
            ]);
    }
}
