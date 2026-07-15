<?php

namespace App\Filament\Widgets;

use App\Models\Layanan;
use Filament\Widgets\ChartWidget;

class BestSellingServicesChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Layanan Terlaris';

    protected function getData(): array
    {

        $services = Layanan::query()
            ->withCount('transaksiDetail')
            ->orderBy('transaksi_detail_count', 'desc')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => $services->pluck('transaksi_detail_count')->toArray(),
                    'backgroundColor' => [
                        '#FF7797',
                        '#FF94AF',
                        '#FFB5C8',
                        '#FFD2DF',
                        '#FFE6EE',
                    ],
                    'borderRadius' => 10,
                ],
            ],

            'labels' => $services
                ->map(fn($service) => "{$service->nama_layanan}")
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
