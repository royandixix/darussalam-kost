<?php

namespace App\Filament\Resources\Tenants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('name')
                    ->label('Nama Penghuni')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Nomor Telepon')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email'),

                TextColumn::make('room.room_number')
                    ->label('Nomor Kamar'),

                TextColumn::make('check_in_date')
                    ->label('Tanggal Masuk')
                    ->date(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),

                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ]);
    }
}