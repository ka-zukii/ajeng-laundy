<?php

namespace App\Filament\Resources\Layanans\Tables;

use App\Enums\JenisPerhitungan;
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
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->columns([
                TextColumn::make('nama_layanan')
                    ->label('Nama Layanan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-sparkles'),
                TextColumn::make('jenis_perhitungan')
                    ->label('Perhitungan')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn(JenisPerhitungan $state) => $state->label())
                    ->color(fn(JenisPerhitungan $state) => match ($state) {
                        JenisPerhitungan::KILOAN => 'info',
                        JenisPerhitungan::SATUAN => 'success',
                    }),
                TextColumn::make('biaya_layanan')
                    ->label('Biaya')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignEnd()
                    ->weight('bold')
                    ->color('primary'),
                TextColumn::make('transaksi_detail_count')
                    ->label('Digunakan')
                    ->counts('transaksiDetail')
                    ->badge()
                    ->alignCenter()
                    ->sortable()
                    ->color(fn($state) => match (true) {
                        $state == 0 => 'gray',
                        $state <= 10 => 'success',
                        $state <= 50 => 'warning',
                        default => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->since()
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
            ->emptyStateHeading('Belum ada layanan')
            ->emptyStateDescription(
                'Tambahkan layanan laundry agar dapat digunakan pada transaksi.'
            )
            ->emptyStateIcon('heroicon-o-sparkles');
    }
}
