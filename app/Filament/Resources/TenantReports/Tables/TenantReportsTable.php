<?php

namespace App\Filament\Resources\TenantReports\Tables;

use App\Filament\Exports\TenantExporter;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Actions\Action;

class TenantReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->columns([
                TextColumn::make('no')->label('No')->rowIndex(),
                TextColumn::make('booking_id')->label('Kode Booking')->prefix('#')->sortable(),
                TextColumn::make('name')->label('Nama Penghuni')->searchable()->sortable(),
                TextColumn::make('phone')->label('Nomor Telepon')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('room.room_number')->label('Nomor Kamar')->searchable()->sortable(),
                TextColumn::make('check_in_date')->label('Tanggal Masuk')->date('d M Y')->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => $state === 'active' ? 'Aktif' : 'Tidak Aktif'),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'active' => 'Aktif',
                    'inactive' => 'Tidak Aktif',
                ]),
            ])
            ->headerActions([
                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(route('admin.reports.pdf.tenants'))
                    ->openUrlInNewTab(),

                ExportAction::make('export')
                    ->label('Export Excel/CSV')
                    ->icon('heroicon-o-table-cells')
                    ->exporter(TenantExporter::class),
            ])
            ->recordActions([])
            ->defaultSort('created_at', 'desc');
    }
}
