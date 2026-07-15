<?php

namespace App\Filament\Resources\PaymentReports\Tables;

use App\Filament\Exports\PaymentExporter;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->columns([
                TextColumn::make('no')->label('No')->rowIndex(),
                TextColumn::make('booking.id')->label('Kode Booking')->prefix('#')->sortable(),
                TextColumn::make('booking.user.name')->label('Penghuni')->searchable()->sortable(),
                TextColumn::make('booking.room.room_number')->label('Nomor Kamar')->searchable()->sortable(),
                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'bank_transfer' => 'Transfer Bank',
                        'qris' => 'QRIS',
                        'cod' => 'COD',
                        default => '-',
                    }),
                TextColumn::make('amount')->label('Jumlah')->money('IDR')->sortable(),
                TextColumn::make('payment_date')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu Verifikasi',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('payment_method')->options([
                    'bank_transfer' => 'Transfer Bank',
                    'qris' => 'QRIS',
                    'cod' => 'COD',
                ]),
                SelectFilter::make('status')->options([
                    'pending' => 'Menunggu Verifikasi',
                    'verified' => 'Terverifikasi',
                    'rejected' => 'Ditolak',
                ]),
            ])
            ->headerActions([
                ExportAction::make('export')
                    ->label('Export Pembayaran')
                    ->exporter(PaymentExporter::class),
            ])
            ->recordActions([])
            ->defaultSort('created_at', 'desc');
    }
}
