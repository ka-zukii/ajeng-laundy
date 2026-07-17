<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Transaksi')
                    ->description('Data transaksi laundry.')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('transaksi.kode_transaksi')
                                    ->label('Kode Transaksi')
                                    ->copyable(),
                                TextEntry::make('transaksi.pelanggan.nama')
                                    ->label('Pelanggan'),
                                TextEntry::make('jumlah_pembayaran')
                                    ->label('Total Tagihan')
                                    ->money('IDR', locale: 'id'),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('transaksi.transaksiDetail.layanan.nama_layanan')
                                    ->label('Layanan'),
                                TextEntry::make('transaksi.prioritas')
                                    ->label('Prioritas')
                                    ->badge()
                                    ->formatStateUsing(fn($state) => $state?->label())
                                    ->color(fn($state) => $state?->color()),
                                TextEntry::make('transaksi.estimasi_selesai')
                                    ->label('Estimasi Selesai')
                                    ->dateTime('d F Y, H:i'),
                            ]),
                    ]),
                Section::make('Informasi Pembayaran')
                    ->description('Status pembayaran pelanggan.')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('metode_pembayaran')
                                    ->label('Metode')
                                    ->formatStateUsing(fn ($state) => $state->label())
                                    ->placeholder('-'),
                                TextEntry::make('status_pembayaran')
                                    ->label('Status')
                                    ->badge()
                                    ->formatStateUsing(fn($state) => $state->label())
                                    ->color(fn($state) => $state->color()),
                                TextEntry::make('tanggal_pembayaran')
                                    ->label('Tanggal Pembayaran')
                                    ->dateTime('d F Y H:i')
                                    ->placeholder('-'),
                            ]),
                    ]),
                Section::make('Informasi Midtrans')
                    ->description('Akan terisi otomatis setelah menggunakan Midtrans.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('payment_gateway')
                                    ->label('Gateway')
                                    ->placeholder('-'),
                                TextEntry::make('payment_type')
                                    ->label('Payment Type')
                                    ->placeholder('-'),
                                TextEntry::make('midtrans_transaction_id')
                                    ->label('Transaction ID')
                                    ->copyable()
                                    ->placeholder('-'),
                                TextEntry::make('snap_token')
                                    ->label('Snap Token')
                                    ->copyable()
                                    ->placeholder('-'),
                                TextEntry::make('va_number')
                                    ->label('VA Number')
                                    ->placeholder('-'),
                                TextEntry::make('expired_at')
                                    ->label('Expired At')
                                    ->dateTime('d F Y H:i')
                                    ->placeholder('-'),
                            ]),
                    ]),
            ]);
    }
}
