<?php

namespace App\Filament\Widgets;

use App\Enums\StatusLaundry;
use App\Enums\StatusPembayaran;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use App\Models\Transaksi;
use Filament\Support\Icons\Heroicon;

class RecentTransactions extends TableWidget
{
    protected static ?int $sort = 4;

    protected static ?string $heading = 'Transaksi Terbaru';

    protected static ?string $description = 'Menampilkan transaksi laundry terbaru.';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaksi::query()
                    ->with([
                        'pelanggan',
                        'transaksiDetail.layanan',
                        'pembayaran',
                    ])
                    ->latest()
                    ->limit(8)
            )
            ->striped()
            ->columns([
                TextColumn::make('kode_transaksi')
                    ->label('Kode')
                    ->weight(FontWeight::Bold)
                    ->copyable()
                    ->searchable()
                    ->copyMessage('Kode transaksi berhasil disalin.'),
                TextColumn::make('pelanggan.nama')
                    ->label('Pelanggan')
                    ->placeholder('Pelanggan Offline')
                    ->description(
                        fn($record) => $record->pelanggan?->nomor_telepon
                    ),
                TextColumn::make('transaksiDetail.layanan.nama_layanan')
                    ->label('Layanan')
                    ->badge()
                    ->color('info'),
                TextColumn::make('prioritas')
                    ->label('Prioritas')
                    ->badge()
                    ->formatStateUsing(
                        fn($state) => $state?->label()
                    )
                    ->color(
                        fn($state) => $state?->color()
                    ),
                TextColumn::make('status_laundry')
                    ->label('Laundry')
                    ->badge()
                    ->formatStateUsing(
                        fn(StatusLaundry $state) => $state->label()
                    )
                    ->color(
                        fn(StatusLaundry $state) => $state->color()
                    ),
                TextColumn::make('pembayaran.status_pembayaran')
                    ->label('Pembayaran')
                    ->badge()
                    ->formatStateUsing(
                        fn(StatusPembayaran $state) => $state->label()
                    )
                    ->color(
                        fn(StatusPembayaran $state) => $state->color()
                    ),
                TextColumn::make('total_biaya')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->alignEnd()
                    ->weight(FontWeight::Bold)
                    ->color('primary'),
                TextColumn::make('created_at')
                    ->label('Masuk')
                    ->since()
                    ->tooltip(
                        fn($record) => $record->created_at?->format('d F Y H:i')
                    ),
            ])
            ->paginated(false)
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Belum ada transaksi')
            ->emptyStateDescription(
                'Transaksi laundry terbaru akan muncul di sini.'
            )
            ->emptyStateIcon(Heroicon::ReceiptPercent);
    }
}
