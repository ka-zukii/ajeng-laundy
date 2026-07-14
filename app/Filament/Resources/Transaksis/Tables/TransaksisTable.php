<?php

namespace App\Filament\Resources\Transaksis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_transaksi')
                    ->label('Kode')
                    ->searchable()
                    ->copyable()
                    ->weight(FontWeight::Bold),

                TextColumn::make('pelanggan.nama')
                    ->label('Pelanggan')
                    ->searchable(),

                TextColumn::make('transaksiDetail.layanan.nama_layanan')
                    ->label('Layanan')
                    ->formatStateUsing(function ($state, $record) {
                        $layanan = $record->transaksiDetail?->layanan;
                        if (! $layanan) {
                            return '-';
                        }

                        return "{$layanan->nama_layanan} ({$layanan->tipe_layanan->label()})";
                    }),

                TextColumn::make('total_biaya')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->alignEnd(),

                TextColumn::make('status_laundry')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->label())
                    ->color(fn($state) => $state->color()),

                TextColumn::make('tanggal_masuk')
                    ->label('Masuk')
                    ->date('d M Y'),

                TextColumn::make('tanggal_selesai')
                    ->label('Selesai')
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
