<?php

namespace App\Filament\Resources\Pembayarans\Pages;

use App\Enums\MetodePembayaran;
use App\Enums\StatusPembayaran;
use App\Filament\Resources\Pembayarans\PembayaranResource;
use App\Models\Pembayaran;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;

class ViewPembayaran extends ViewRecord
{
    protected static string $resource = PembayaranResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('bayarTunai')
                ->label('Bayar Tunai')
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->visible(fn() => $this->record->isPending())
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'metode_pembayaran'  => MetodePembayaran::TUNAI,
                        'status_pembayaran'  => StatusPembayaran::SUKSES,
                        'tanggal_pembayaran' => now(),
                    ]);
                    Notification::make()
                        ->title('Pembayaran berhasil.')
                        ->success()
                        ->send();
                    $this->refreshFormData([
                        'metode_pembayaran',
                        'status_pembayaran',
                        'tanggal_pembayaran',
                    ]);
                }),

            Action::make('midtrans')
                ->label('Bayar Midtrans')
                ->icon('heroicon-o-credit-card')
                ->color('info')
                ->visible(fn() => in_array(
                    $this->record->status_pembayaran,
                    [
                        StatusPembayaran::MENGUNGGU,
                        StatusPembayaran::DIBATALKAN,
                    ],
                    true,
                ))
                ->action(function (Pembayaran $record) {

                    $paymentService = app(
                        \App\Services\Pembayaran\PaymentService::class
                    );

                    if ($record->isCancelled()) {
                        $paymentService->retry($record);
                        $record->refresh();
                    } else {
                        $paymentService->refreshSnapToken(
                            $record->transaksi,
                        );
                    }

                    return redirect()->route(
                        'payment',
                        $record->transaksi,
                    );
                }),

            Action::make('batalkan')
                ->label('Batalkan')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn() => $this->record->isPending())
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'status_pembayaran' => StatusPembayaran::DIBATALKAN,
                    ]);

                    Notification::make()
                        ->title('Pembayaran dibatalkan.')
                        ->warning()
                        ->send();

                    $this->refreshFormData([
                        'status_pembayaran',
                    ]);
                }),

            Action::make('cetak')
                ->label('Cetak Nota')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->action(function () {
                    // Generate PDF nanti
                }),

        ];
    }
}
