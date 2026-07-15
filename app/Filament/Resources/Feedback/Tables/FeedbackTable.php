<?php

namespace App\Filament\Resources\Feedback\Tables;

use App\Filament\Exports\FeedbackExporter;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FeedbackTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->columns([
                TextColumn::make('no')->label('No')->rowIndex(),
                TextColumn::make('user.name')->label('Penghuni')->searchable()->sortable(),
                TextColumn::make('booking.room.room_number')->label('Kamar')->searchable()->sortable(),
                TextColumn::make('rating')->label('Rating')->suffix('/5')->sortable(),
                TextColumn::make('comment')->label('Komentar')->limit(80)->searchable()->wrap(),
                IconColumn::make('is_published')->label('Dipublikasikan')->boolean(),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('rating')->options([
                    1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5',
                ]),
                SelectFilter::make('is_published')->options([
                    1 => 'Dipublikasikan',
                    0 => 'Belum Dipublikasikan',
                ]),
            ])
            ->headerActions([
                ExportAction::make('export')
                    ->label('Export Feedback')
                    ->exporter(FeedbackExporter::class),
            ])
            ->recordActions([
                EditAction::make()->label('Kelola'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
