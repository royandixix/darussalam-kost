<?php

namespace App\Filament\Resources\MaintenanceReports\Tables;

use App\Models\MaintenanceReport;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaintenanceReportsTable
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
                    ->searchable()
                    ->sortable(),

                TextColumn::make('room.room_number')
                    ->label('Kamar')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Judul Laporan')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->size(60),

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
                    ->label('Status Laporan')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'assigned' => 'Ditugaskan',
                        'in_progress' => 'Sedang Dikerjakan',
                        'completed' => 'Selesai',
                        default => $state,
                    }),

                TextColumn::make('technician_name')
                    ->label('Teknisi')
                    ->state(function (MaintenanceReport $record): string {
                        $latestUpdate = $record->updates()
                            ->with('technician')
                            ->latest()
                            ->first();

                        return $latestUpdate?->technician?->name ?? '-';
                    }),

                TextColumn::make('latest_technician_note')
                    ->label('Catatan Teknisi Terakhir')
                    ->state(function (MaintenanceReport $record): string {
                        $latestUpdate = $record->updates()
                            ->latest()
                            ->first();

                        return $latestUpdate?->note ?? '-';
                    })
                    ->limit(60)
                    ->searchable(false),

                TextColumn::make('latest_update_status')
                    ->label('Status Update')
                    ->state(function (MaintenanceReport $record): string {
                        $latestUpdate = $record->updates()
                            ->latest()
                            ->first();

                        return match ($latestUpdate?->status) {
                            'assigned' => 'Ditugaskan',
                            'in_progress' => 'Sedang Dikerjakan',
                            'completed' => 'Selesai',
                            default => '-',
                        };
                    })
                    ->badge(),

                TextColumn::make('latest_update_date')
                    ->label('Update Terakhir')
                    ->state(function (MaintenanceReport $record): string {
                        $latestUpdate = $record->updates()
                            ->latest()
                            ->first();

                        return $latestUpdate?->created_at
                            ? $latestUpdate->created_at->format('d M Y H:i')
                            : '-';
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
                        ->modalHeading('Hapus Data Laporan Perbaikan')
                        ->modalDescription('Apakah Anda yakin ingin menghapus data laporan perbaikan yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Hapus'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}