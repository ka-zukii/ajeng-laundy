<?php

namespace App\Filament\Widgets;

use App\Enums\StatusLaundry;
use App\Enums\UserRole;
use App\Models\Transaksi;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
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
                ->descriptionIcon(Heroicon::User)
                ->color('primary'),

            Stat::make('Transaksi', Transaksi::query()->count('id'))
                ->description('Jumlah total transaksi yang telah dilakukan.')
                ->descriptionIcon(Heroicon::ReceiptPercent)
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
                ->descriptionIcon(Heroicon::Banknotes)
                ->color('warning'),

            Stat::make('Cucian Diproses', Transaksi::whereStatusLaundry(StatusLaundry::DIPROSES)->count())
                ->description('Jumlah cucian yang sedang dalam proses.')
                ->descriptionIcon(Heroicon::Sparkles)
                ->color('info'),
        ];
    }
}
