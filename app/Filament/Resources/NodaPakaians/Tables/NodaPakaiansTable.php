<?php

namespace App\Filament\Resources\NodaPakaians\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NodaPakaiansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->columns([
                TextColumn::make('nama_noda')
                    ->label('Noda Pakaian')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-sparkles'),
                TextColumn::make('solusi')
                    ->label('Solusi')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn($record) => $record->solusi)
                    ->wrap(),
                TextColumn::make('biaya_tambahan')
                    ->label('Biaya Tambahan')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignEnd()
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state == 0 => 'success',
                        $state <= 5000 => 'warning',
                        default => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diubah')
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
            ->emptyStateHeading('Belum ada data noda pakaian')
            ->emptyStateDescription(
                'Tambahkan data noda pakaian untuk membantu proses pencucian dan perhitungan biaya tambahan.'
            )
            ->emptyStateIcon('heroicon-o-sparkles');
    }
}
