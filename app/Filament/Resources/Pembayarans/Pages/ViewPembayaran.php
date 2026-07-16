<?php

namespace App\Filament\Resources\Pembayarans\Pages;

use App\Enums\StatusPembayaran;
use App\Filament\Resources\Pembayarans\PembayaranResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewPembayaran extends ViewRecord
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('bayarTunai')
                ->label('Bayar Tunai')
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->visible(fn() => $this->record->status_pembayaran === StatusPembayaran::MENGUNGGU)
                ->requiresConfirmation()
                ->action(function () {

                    $this->record->update([
                        'metode_pembayaran' => 'tunai',
                        'status_pembayaran' => StatusPembayaran::SUKSES,
                        'tanggal_pembayaran' => now(),
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Pembayaran berhasil.')
                        ->send();

                    $this->redirect(request()->header('Referer'));
                }),
            Actions\Action::make('midtrans')
                ->label('Bayar Midtrans')
                ->icon('heroicon-o-credit-card')
                ->color('info')
                ->visible(fn() => $this->record->status_pembayaran === StatusPembayaran::MENGUNGGU)
                ->action(function () {
                    // nanti isi ketika integrasi Midtrans
                }),
            Actions\Action::make('batalkan')
                ->label('Batalkan')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn() => $this->record->status_pembayaran === StatusPembayaran::MENGUNGGU)
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'status_pembayaran' => StatusPembayaran::DIBATALKAN,
                    ]);
                    Notification::make()
                        ->warning()
                        ->title('Pembayaran dibatalkan.')
                        ->send();
                    $this->redirect(request()->header('Referer'));
                }),
            Actions\Action::make('cetak')
                ->label('Cetak Nota')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->action(function () {
                    // buat PDF
                }),
        ];
    }
}
