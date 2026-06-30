<?php

namespace App\Filament\Resources\PaymentReports\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('booking.id')
                    ->label('Kode Pemesanan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('booking.user.name')
                    ->label('Penghuni')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('booking.room.room_number')
                    ->label('Nomor Kamar')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Jumlah Pembayaran')
                    ->money('IDR')
                    ->sortable(),

                ImageColumn::make('payment_proof')
                    ->label('Bukti')
                    ->disk('public')
                    ->size(60),

                TextColumn::make('payment_date')
                    ->label('Tanggal Pembayaran')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu Verifikasi',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Data Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Tanggal Data Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'pending' => 'Menunggu Verifikasi',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}