<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
                Section::make('Informasi Pengguna')
                    ->description('Lengkapi data profil pengguna di bawah ini.')
                    ->icon(Heroicon::User)
                    ->components([
                        Grid::make(2)
                            ->components([
                                TextInput::make('username')
                                    ->label('Username')
                                    ->unique(table: 'users', ignoreRecord:true)
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Masukkan username'),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->unique(table: 'users', ignoreRecord: true)
                                    ->placeholder('Masukkan alamat email')
                                    ->maxLength(255),

                                Select::make('pelanggan_id')
                                    ->label('Hubungkan ke Pelanggan')
                                    ->relationship(
                                        name: 'pelanggan',
                                        titleAttribute: 'nomor_telepon',
                                    )
                                    ->searchable(['nama', 'nomor_telepon'])
                                    ->getOptionLabelFromRecordUsing(
                                        fn($record) => "{$record->nama} • {$record->nomor_telepon}"
                                    )
                                    ->helperText('Pilih pelanggan yang sudah pernah bertransaksi.')
                                    ->preload(),

                                Select::make('role')
                                    ->label('Role')
                                    ->options(UserRole::options())
                                    ->default(UserRole::PELANGGAN->value)
                                    ->required(),

                                TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->dehydrated(fn($state) => filled($state))
                                    ->required(fn(string $context): bool => $context === 'create')
                                    ->placeholder(fn(string $context): string => $context === 'create' ? 'Masukkan password' : 'Kosongkan jika tidak ingin mengubah password')
                                    ->maxLength(255),
                            ]),
                    ]),
            ]);
    }
}
