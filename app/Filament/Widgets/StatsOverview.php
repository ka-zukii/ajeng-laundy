<?php

namespace App\Filament\Widgets;

use App\Enums\StatusLaundry;
use App\Enums\StatusPembayaran;
use App\Enums\UserRole;
use App\Models\Transaksi;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::where('role', UserRole::PELANGGAN)->count())
                ->description('Jumlah total pengguna yang terdaftar di sistem.')
                ->descriptionIcon('heroicon-m-user')
                ->color('primary'),
            Stat::make('Transaksi', Transaksi::query()->count())
                ->description('Jumlah total transaksi yang telah dilakukan.')
                ->descriptionIcon('heroicon-m-receipt-percent')
                ->color('success'),
            Stat::make(
                'Pendapatan',
                Number::currency(
                    Transaksi::query()
                        ->whereBetween('tanggal_masuk', [
                            now()->startOfMonth(),
                            now()->endOfMonth(),
                        ])
                        ->whereHas('pembayaran', function ($query) {
                            $query->where('status_pembayaran', StatusPembayaran::SUKSES->value);
                        })
                        ->sum('total_biaya'),
                    'IDR',
                    'id'
                )
            )
                ->description('Total pendapatan bulan ini.')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
            Stat::make('Cucian Diproses', Transaksi::whereStatusLaundry(StatusLaundry::DIPROSES)->count())
                ->description('Jumlah cucian yang sedang dalam proses.')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),
        ];
    }
}
