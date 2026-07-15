<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Filament\Exports\BookingExporter;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Actions\Action;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->columns([
                TextColumn::make('no')->label('No')->rowIndex(),
                TextColumn::make('id')->label('Kode')->prefix('#')->sortable(),
                TextColumn::make('user.name')->label('Penghuni')->searchable()->sortable(),
                TextColumn::make('room.room_number')->label('Kamar')->searchable()->sortable(),
                TextColumn::make('check_in_date')->label('Tanggal Masuk')->date('d M Y')->sortable(),
                TextColumn::make('duration_month')->label('Durasi')->suffix(' bulan')->sortable(),
                TextColumn::make('total_price')->label('Total Kontrak')->money('IDR')->sortable(),
                TextColumn::make('payment.status')
                    ->label('Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                        default => '-',
                    }),
                TextColumn::make('status')
                    ->label('Status Booking')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Menunggu Persetujuan',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'completed' => 'Selesai',
                        default => $state,
                    }),
                TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'pending' => 'Menunggu Persetujuan',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                    'completed' => 'Selesai',
                ]),
            ])
            ->headerActions([
                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(route('admin.reports.pdf.bookings'))
                    ->openUrlInNewTab(),

                ExportAction::make('export')
                    ->label('Export Excel/CSV')
                    ->icon('heroicon-o-table-cells')
                    ->exporter(BookingExporter::class),
            ])
            ->recordActions([
                EditAction::make()->label('Kelola'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
