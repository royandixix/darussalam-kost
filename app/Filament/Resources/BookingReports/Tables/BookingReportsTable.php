<?php

namespace App\Filament\Resources\BookingReports\Tables;

use App\Filament\Exports\MaintenanceReportExporter;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookingReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->columns([
                TextColumn::make('no')->label('No')->rowIndex(),
                TextColumn::make('user.name')->label('Penghuni')->searchable()->sortable(),
                TextColumn::make('room.room_number')->label('Nomor Kamar')->searchable()->sortable(),
                TextColumn::make('assignedTechnician.name')->label('Teknisi')->placeholder('-'),
                TextColumn::make('title')->label('Judul Laporan')->searchable()->sortable(),
                TextColumn::make('description')->label('Deskripsi')->limit(70)->searchable()->wrap(),
                TextColumn::make('priority')->label('Prioritas')->badge(),
                TextColumn::make('status')->label('Status')->badge(),
                TextColumn::make('created_at')->label('Tanggal Laporan')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('priority')->options([
                    'low' => 'Rendah',
                    'medium' => 'Sedang',
                    'high' => 'Tinggi',
                ]),
                SelectFilter::make('status')->options([
                    'pending' => 'Menunggu',
                    'assigned' => 'Ditugaskan',
                    'in_progress' => 'Sedang Dikerjakan',
                    'completed' => 'Selesai',
                ]),
            ])
            ->headerActions([
                ExportAction::make('export')
                    ->label('Export Maintenance')
                    ->exporter(MaintenanceReportExporter::class),
            ])
            ->recordActions([])
            ->defaultSort('created_at', 'desc');
    }
}
