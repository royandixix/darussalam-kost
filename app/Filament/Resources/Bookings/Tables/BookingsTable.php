<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsTable
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

                TextColumn::make('room.room_number')
                    ->label('Kamar')
                    ->searchable(),

                TextColumn::make('check_in_date')
                    ->label('Tanggal Masuk')
                    ->date()
                    ->sortable(),

                TextColumn::make('duration_month')
                    ->label('Durasi Sewa')
                    ->suffix(' bulan')
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label('Total Biaya')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status Pemesanan')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu Persetujuan',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'completed' => 'Selesai',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Tanggal Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->label('Edit'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->modalHeading('Hapus Data Pemesanan')
                        ->modalDescription('Apakah Anda yakin ingin menghapus data pemesanan yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Hapus'),
                ]),
            ]);
    }
}