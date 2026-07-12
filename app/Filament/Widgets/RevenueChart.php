<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $heading = 'Pendapatan Bulanan';

    protected function getData(): array
    {
        $months = [];
        $revenues = [];

        foreach (range(1, 12) as $month) {

            $months[] = now()->startOfYear()->addMonths($month - 1)->format('M');

            $revenues[] = Transaksi::query()
                ->whereBetween('tanggal_selesai', [
                    now()->startOfYear()->addMonths($month - 1),
                    now()->startOfYear()->addMonths($month),
                ], 'and', false)
                ->sum('total_biaya');
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