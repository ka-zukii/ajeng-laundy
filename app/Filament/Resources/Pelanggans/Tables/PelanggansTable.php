<?php

namespace App\Filament\Resources\Pelanggans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PelanggansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("nama")
                    ->label('Nama Pelanggan'),
                TextColumn::make('nomor_telepon')
                    ->label('Nomor Telepon'),
                TextColumn::make('transaksi_count')
                    ->label('Total Transaksi'),
                TextColumn::make('transaksi_sum_total_biaya')
                    ->label('Total Pengeluaran')
                    ->money('IDR', locale: 'id'),
                TextColumn::make('transaksi_max_tanggal_masuk')
                    ->label('Terakhir Laundry')
                    ->date('d M Y'),
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
