<?php

namespace App\Filament\Teknisi\Resources\MaintenanceReports\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaintenanceReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('user.name')
                    ->label('Penghuni')
                    ->searchable(),

                TextColumn::make('room.room_number')
                    ->label('Kamar')
                    ->searchable(),

                TextColumn::make('title')
                    ->label('Judul Kerusakan')
                    ->searchable(),

                ImageColumn::make('photo')
                    ->label('Foto')
                    ->size(60),

                BadgeColumn::make('priority')
                    ->label('Prioritas')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'low' => 'Rendah',
                        'medium' => 'Sedang',
                        'high' => 'Tinggi',
                        default => $state,
                    }),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'assigned' => 'Ditugaskan',
                        'in_progress' => 'Sedang Dikerjakan',
                        'completed' => 'Selesai',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Laporan')
                    ->dateTime('d M Y H:i'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Update Status'),
            ]);
    }
}