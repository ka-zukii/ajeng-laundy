<?php

namespace App\Filament\Widgets;

use App\Enums\StatusPembayaran;
use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $heading = 'Pendapatan Bulanan';

    protected function getData(): array
    {
        $currentYear = now()->year;
        $monthlyRevenue = Transaksi::query()
            ->select(
                DB::raw('MONTH(tanggal_masuk) as month'),
                DB::raw('SUM(total_biaya) as total')
            )
            ->whereYear('tanggal_masuk', $currentYear)
            ->whereHas('pembayaran', function ($query) {
                $query->where('status_pembayaran', StatusPembayaran::SUKSES->value);
            })
            ->groupBy(DB::raw('MONTH(tanggal_masuk)'))
            ->pluck('total', 'month')
            ->toArray();

        $months = [];
        $revenues = [];

        foreach (range(1, 12) as $monthNumber) {
            $months[] = Carbon::create()->month($monthNumber)->format('M');
            $revenues[] = $monthlyRevenue[$monthNumber] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $revenues,
                    'borderColor' => '#FF7797',
                    'backgroundColor' => 'rgba(255,119,151,.2)',
                    'fill' => true,
                    'tension' => .4,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
