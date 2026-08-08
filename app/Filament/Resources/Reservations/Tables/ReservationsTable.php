<?php

namespace App\Filament\Resources\Reservations\Tables;

use App\Enums\StatusReservation;
use App\Filament\Resources\Transaksis\TransaksiResource;
use App\Models\Reservation;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ReservationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID Reservasi')
                    ->formatStateUsing(fn($state) => '#RES-' . str_pad($state, 4, '0', STR_PAD_LEFT))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('pelanggan.nama')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('pelanggan.nomor_telepon')
                    ->label('No. WhatsApp')
                    ->searchable(),

                TextColumn::make('tanggal_penjemputan')
                    ->label('Waktu Penjemputan')
                    ->dateTime('d M Y - H:i')
                    ->sortable(),

                TextColumn::make('status_reservation')
                    ->label('Status')
                    ->badge()
                    ->color(fn(StatusReservation $state): string => match ($state) {
                        StatusReservation::MENUNGGU => 'warning',
                        StatusReservation::DIJADWALKAN => 'info',
                        StatusReservation::SELESAI => 'success',
                        StatusReservation::DIBATALKAN => 'danger',
                    })
                    ->formatStateUsing(fn(StatusReservation $state): string => $state->label()),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status_reservation')
                    ->label('Filter Status')
                    ->options(StatusReservation::class),
            ])
            ->recordActions([
                Action::make('set_menunggu')
                    ->label('Set Menunggu')
                    ->icon('heroicon-o-clock')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (Reservation $record) {
                        $record->update(['status_reservation' => StatusReservation::MENUNGGU]);

                        Notification::make()
                            ->title('Status diubah menjadi Menunggu')
                            ->success()
                            ->send();
                    })
                    ->hidden(
                        fn(Reservation $record) =>
                        $record->status_reservation === StatusReservation::MENUNGGU ||
                            $record->status_reservation === StatusReservation::SELESAI
                    ),

                Action::make('set_selesai')
                    ->label('Selesai & Buat Transaksi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->url(fn(Reservation $record): string => TransaksiResource::getUrl('create', [
                        'reservation_id' => $record->id,
                        'pelanggan_id' => $record->pelanggan_id,
                        'layanan_id' => $record->layanan_id,
                    ]))
                    ->hidden(fn(Reservation $record) => $record->status_reservation === StatusReservation::SELESAI),

                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal_penjemputan', 'desc');
    }
}
