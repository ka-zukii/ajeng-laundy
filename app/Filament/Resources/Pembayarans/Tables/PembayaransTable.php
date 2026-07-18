<?php

namespace App\Filament\Resources\Pembayarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->columns([
                TextColumn::make('transaksi.kode_transaksi')
                    ->label('Kode Transaksi')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Kode transaksi berhasil disalin.'),
                TextColumn::make('transaksi.pelanggan.nama')
                    ->label('Pelanggan')
                    ->description(
                        fn($record) => $record->transaksi?->pelanggan?->nomor_telepon
                    )
                    ->searchable(['nama', 'nomor_telepon'])
                    ->sortable(),
                TextColumn::make('jumlah_pembayaran')
                    ->label('Nominal')
                    ->money('IDR', locale: 'id')
                    ->weight(FontWeight::Bold)
                    ->color('primary')
                    ->alignEnd()
                    ->sortable(),
                TextColumn::make('metode_pembayaran')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->label())
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('status_pembayaran')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(
                        fn($state) => $state->label()
                    )
                    ->color(
                        fn($state) => $state->color()
                    ),
                TextColumn::make('tanggal_pembayaran')
                    ->label('Tanggal Pembayaran')
                    ->placeholder('-')
                    ->since()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([

                ]),
            ])
            ->emptyStateHeading('Belum ada pembayaran')
            ->emptyStateDescription(
                'Pembayaran akan muncul secara otomatis setelah transaksi dibuat.'
            )
            ->emptyStateIcon('heroicon-o-banknotes');
    }
}
