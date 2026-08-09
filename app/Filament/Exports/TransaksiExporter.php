<?php

namespace App\Filament\Exports;

use App\Models\Transaksi;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TransaksiExporter extends Exporter
{
    protected static ?string $model = Transaksi::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('kode_transaksi')
                ->label('Kode Transaksi'),

            ExportColumn::make('pelanggan.nama')
                ->label('Nama Pelanggan'),

            ExportColumn::make('pelanggan.nomor_telepon')
                ->label('No. WhatsApp'),

            ExportColumn::make('tanggal_masuk')
                ->label('Tanggal Masuk'),

            ExportColumn::make('pembayaran.metode_pembayaran')
                ->label('Metode Bayar'),

            ExportColumn::make('status_laundry')
                ->label('Status Laundry'),

            ExportColumn::make('pembayaran.status_pembayaran')
                ->label('Status Pembayaran'),

            ExportColumn::make('total_biaya')
                ->label('Total Biaya (Rp)'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Laporan transaksi Anda telah selesai diexport dan siap diunduh.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diexport.';
        }

        return $body;
    }
}
