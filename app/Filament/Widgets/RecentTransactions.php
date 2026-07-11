<?php

namespace App\Filament\Widgets;

use App\Enums\StatusLaundry;
use App\Models\Transaksi;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentTransactions extends TableWidget
{
    protected static ?int $sort = 4;
    protected static ?string $heading = 'Transaksi Terkini';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Transaksi::query()->latest()->limit(10))
            ->columns([
                TextColumn::make('kode_transaksi')
                    ->label('Kode Transaksi')
                    ->searchable(),

                TextColumn::make('user.nama')
                    ->label('Pelanggan'),

                TextColumn::make('transaksiDetail.layanan.nama_layanan')
                    ->label('Layanan'),

                TextColumn::make('total_biaya')
                    ->label('Total')
                    ->money('IDR'),

                TextColumn::make('status_laundry')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn(StatusLaundry $state) => $state->label()
                    )
                    ->color(
                        fn(StatusLaundry $state) => $state->color()
                    ),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
