<?php

namespace App\Filament\Resources\MaintenanceReports\Tables;

use App\Filament\Exports\MaintenanceReportExporter;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MaintenanceReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->columns([
                TextColumn::make('no')->label('No')->rowIndex(),
                TextColumn::make('user.name')->label('Penghuni')->searchable()->sortable(),
                TextColumn::make('room.room_number')->label('Kamar')->searchable()->sortable(),
                TextColumn::make('assignedTechnician.name')->label('Teknisi')->placeholder('Belum ditugaskan')->searchable(),
                TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                ImageColumn::make('photo')->label('Foto')->disk('public')->size(60),
                TextColumn::make('priority')
                    ->label('Prioritas')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'low' => 'Rendah',
                        'medium' => 'Sedang',
                        'high' => 'Tinggi',
                        default => $state,
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'assigned' => 'Ditugaskan',
                        'in_progress' => 'Sedang Dikerjakan',
                        'completed' => 'Selesai',
                        default => $state,
                    }),
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
            ->recordActions([
                EditAction::make()->label('Kelola'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
