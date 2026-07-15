<?php

namespace App\Filament\Resources\Layanans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LayanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_layanan')
                    ->label("Layanan"),
                
                TextColumn::make('jenis_perhitungan')
                    ->label("Perhitungan")
                    ->formatStateUsing(fn ($state) => $state->label()),

                TextColumn::make("biaya_layanan")
                    ->label("Biaya Layanan")
                    ->money('IDR', locale: 'id')
                    ->alignEnd(),
                TextColumn::make('transaksi_detail_count')
                    ->label("Jumlah Transaksi")
                    ->counts('transaksiDetail')
                    ->alignEnd(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
