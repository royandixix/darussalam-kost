<?php

namespace App\Filament\Resources\Feedback\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeedbackTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('user.name')
                    ->label('Penghuni')
                    ->searchable(),

                TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(40),

                TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->modalHeading('Hapus Data Feedback')
                        ->modalDescription('Apakah Anda yakin ingin menghapus data yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Hapus'),
                ]),
            ]);
    }
}