<?php

namespace App\Filament\Resources\Pelanggans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class PelangganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('Nama Lengkap'),
                TextInput::make('Nomor Telepon'),
                Textarea::make('Alamat')
            ]);
    }
}
