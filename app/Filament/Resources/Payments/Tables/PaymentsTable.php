<?php

namespace App\Filament\Resources\Payments\Tables;

use App\Models\Payment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('row_number')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('booking.id')
                    ->label('Kode Booking')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('booking.user.name')
                    ->label('Penghuni')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('booking.room.room_number')
                    ->label('Kamar')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'bank_transfer' => 'Transfer Bank',
                        'qris' => 'QRIS',
                        'cod' => 'COD',
                        default => '-',
                    }),

                TextColumn::make('sender_name_display')
                    ->label('Nama Pengirim')
                    ->state(function (Payment $record): string {
                        return match ($record->payment_method) {
                            'bank_transfer' => $record->sender_name ?: '-',
                            'qris' => $record->sender_name ?: '-',
                            'cod' => 'Bayar di Tempat',
                            default => '-',
                        };
                    }),

                TextColumn::make('sender_bank_display')
                    ->label('Bank/Aplikasi')
                    ->state(function (Payment $record): string {
                        return match ($record->payment_method) {
                            'bank_transfer' => $record->sender_bank ?: '-',
                            'qris' => 'QRIS',
                            'cod' => 'Tidak Perlu',
                            default => '-',
                        };
                    }),

                TextColumn::make('amount')
                    ->label('Jumlah Pembayaran')
                    ->money('IDR')
                    ->sortable(),

                ImageColumn::make('payment_proof')
                    ->label('Bukti')
                    ->disk('public')
                    ->size(60),

                TextColumn::make('proof_status')
                    ->label('Status Bukti')
                    ->state(function (Payment $record): string {
                        if ($record->payment_method === 'cod') {
                            return 'Tidak Perlu Bukti';
                        }

                        return $record->payment_proof ? 'Bukti Ada' : 'Bukti Kosong';
                    })
                    ->badge()
                    ->color(function (Payment $record): string {
                        if ($record->payment_method === 'cod') {
                            return 'gray';
                        }

                        return $record->payment_proof ? 'success' : 'danger';
                    }),

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
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make()
                    ->label('Verifikasi / Edit'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->modalHeading('Hapus Data Pembayaran')
                        ->modalDescription('Apakah Anda yakin ingin menghapus data pembayaran yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Hapus'),
                ]),
            ]);
    }
}