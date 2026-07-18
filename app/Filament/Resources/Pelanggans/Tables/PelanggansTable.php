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
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->columns([
                TextColumn::make('nama')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('nomor_telepon')
                    ->label('Nomor Telepon')
                    ->copyable()
                    ->copyMessage('Nomor telepon berhasil disalin.')
                    ->searchable(),
                TextColumn::make('transaksi_count')
                    ->label('Transaksi')
                    ->counts('transaksi')
                    ->badge()
                    ->sortable()
                    ->alignCenter()
                    ->color(fn($state) => match (true) {
                        $state == 0 => 'gray',
                        $state <= 5 => 'success',
                        $state <= 15 => 'warning',
                        default => 'danger',
                    }),
                TextColumn::make('transaksi_sum_total_biaya')
                    ->label('Total Pengeluaran')
                    ->sum('transaksi', 'total_biaya')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignEnd()
                    ->weight('bold')
                    ->color('primary'),
                TextColumn::make('transaksi_max_tanggal_masuk')
                    ->label('Terakhir Laundry')
                    ->max('transaksi', 'tanggal_masuk')
                    ->since()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus')
                        ->icon('heroicon-o-trash'),
                ]),
            ])
            ->emptyStateHeading('Belum ada pelanggan')
            ->emptyStateDescription(
                'Pelanggan akan muncul setelah ditambahkan melalui menu pelanggan atau saat membuat transaksi.'
            )
            ->emptyStateIcon('heroicon-o-user-group');
    }
}
