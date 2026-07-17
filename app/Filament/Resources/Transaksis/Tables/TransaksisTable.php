<?php

namespace App\Filament\Resources\Transaksis\Tables;

use App\Enums\StatusPembayaran;
use App\Filament\Resources\Pembayarans\PembayaranResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with([
                'pelanggan',
                'transaksiDetail.layanan',
                'pembayaran',
            ]))
            ->defaultSort('tanggal_masuk', 'desc')
            ->striped()
            ->columns([
                TextColumn::make('kode_transaksi')
                    ->label('Kode Transaksi')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Kode transaksi berhasil disalin.'),
                TextColumn::make('pelanggan.nama')
                    ->label('Pelanggan')
                    ->placeholder('Pelanggan Offline')
                    ->description(fn($record) => $record->pelanggan?->nomor_telepon)
                    ->searchable(['nama', 'nomor_telepon'])
                    ->sortable(),
                TextColumn::make('transaksiDetail.layanan.nama_layanan')
                    ->label('Layanan')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('prioritas')
                    ->label('Prioritas')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state?->label())
                    ->color(fn($state) => $state?->color()),
                TextColumn::make('pembayaran.status_pembayaran')
                    ->label('Pembayaran')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(
                        fn(StatusPembayaran $state) => $state->label()
                    )
                    ->color(
                        fn(StatusPembayaran $state) => $state->color()
                    ),
                TextColumn::make('status_laundry')
                    ->label('Laundry')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state->label())
                    ->color(fn($state) => $state->color()),
                TextColumn::make('estimasi_selesai')
                    ->label('Estimasi')
                    ->alignCenter()
                    ->dateTime('d F Y, H:i')
                    ->sortable(),
                TextColumn::make('total_biaya')
                    ->label('Total Biaya')
                    ->money('IDR', locale: 'id')
                    ->weight(FontWeight::Bold)
                    ->color('primary')
                    ->alignEnd()
                    ->sortable(),
                TextColumn::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('tanggal_selesai')
                    ->label('Tanggal Selesai')
                    ->placeholder('-')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->label('Edit')
                    ->icon(Heroicon::PencilSquare)
                    ->color('warning'),
                Action::make('payment')
                    ->hidden(fn($record) => $record->pembayaran === null)
                    ->label(fn($record) => match ($record->pembayaran?->status_pembayaran) {
                        StatusPembayaran::SUKSES => 'Lihat Pembayaran',
                        StatusPembayaran::DIBATALKAN => 'Bayar Ulang',
                        default => 'Pembayaran',
                    })
                    ->icon(fn($record) => match ($record->pembayaran?->status_pembayaran) {
                        StatusPembayaran::SUKSES => Heroicon::Eye,
                        StatusPembayaran::DIBATALKAN => Heroicon::ArrowPath,
                        default => 'heroicon-o-credit-card',
                    })
                    ->color(fn($record) => match ($record->pembayaran?->status_pembayaran) {
                        StatusPembayaran::SUKSES => 'gray',
                        StatusPembayaran::DIBATALKAN => 'warning',
                        default => 'success',
                    })
                    ->tooltip('Kelola pembayaran')
                    ->modalAlignment(Alignment::Center)
                    ->url(fn($record) => PembayaranResource::getUrl(
                        'view',
                        [
                            'record' => $record->pembayaran,
                        ]
                    )),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada transaksi')
            ->emptyStateDescription(
                'Transaksi laundry yang dibuat akan muncul di halaman ini.'
            )
            ->emptyStateIcon('heroicon-o-receipt-percent');
    }
}
