<?php

namespace App\Filament\Teknisi\Resources\MaintenanceUpdates\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaintenanceUpdatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('report.title')
                    ->label('Laporan Kerusakan')
                    ->searchable(),

                TextColumn::make('technician.name')
                    ->label('Teknisi')
                    ->searchable(),

                TextColumn::make('note')
                    ->label('Catatan')
                    ->limit(50),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'assigned' => 'Ditugaskan',
                        'in_progress' => 'Sedang Dikerjakan',
                        'completed' => 'Selesai',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Update')
                    ->dateTime('d M Y H:i'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit'),
            ]);
    }
}