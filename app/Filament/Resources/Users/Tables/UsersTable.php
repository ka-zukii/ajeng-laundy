<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\UserRole;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('username')->label('Username')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('role')->label('Role')
                ->formatStateUsing(fn(UserRole $state) => $state->label())
                ->color(fn(UserRole $state) => $state->color()),
                TextColumn::make('created_at')->label('Dibuat Pada')->dateTime('d F Y, H:i')->timezone('Asia/Jakarta')->sortable(),
                TextColumn::make('updated_at')->label('Diperbarui Pada')->dateTime('d F Y, H:i')->timezone('Asia/Jakarta')->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
