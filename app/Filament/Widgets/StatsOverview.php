<?php

namespace App\Filament\Widgets;

use App\Enums\StatusLaundry;
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
            Stat::make('Total Pengguna', User::query()->where('role', UserRole::PELANGGAN->value)->count('id'))
                ->description('Jumlah total pengguna yang terdaftar di sistem.')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Transaksi', Transaksi::query()->count('id'))
                ->description('Jumlah total transaksi yang telah dilakukan.')
                ->descriptionIcon('heroicon-o-receipt-percent')
                ->color('success'),

            Stat::make(
                'Pendapatan',
                Number::currency(
                    Transaksi::query()
                        ->whereBetween('tanggal_selesai', [
                            now()->startOfMonth(),
                            now()->endOfMonth(),
                        ], 'and', false)
                        ->sum('total_biaya'),
                    'IDR',
                    'id'
                )
            )
                ->description('Total pendapatan bulan ini.')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('warning'),

            Stat::make('Cucian Diproses', Transaksi::query()->whereStatusLaundry(StatusLaundry::DIPROSES)->count('id'))
                ->description('Jumlah cucian yang sedang dalam proses.')
                ->descriptionIcon('heroicon-o-sparkles')
                ->color('info'),
        ];
    }
}
