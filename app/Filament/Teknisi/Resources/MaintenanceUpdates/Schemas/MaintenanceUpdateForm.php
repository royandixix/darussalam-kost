<?php

namespace App\Filament\Teknisi\Resources\MaintenanceUpdates\Schemas;

use App\Models\MaintenanceReport;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class MaintenanceUpdateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('maintenance_report_id')
                    ->label('Laporan Kerusakan')
                    ->options(fn () => MaintenanceReport::query()
                        ->with(['user', 'room'])
                        ->latest()
                        ->get()
                        ->mapWithKeys(fn (MaintenanceReport $report): array => [
                            $report->id => $report->title . ' - ' . ($report->user?->name ?? 'Penghuni') . ' - Kamar ' . ($report->room?->room_number ?? '-'),
                        ])
                        ->toArray())
                    ->searchable()
                    ->required(),

                Hidden::make('technician_id')
                    ->default(fn () => Auth::id()),

                Textarea::make('note')
                    ->label('Catatan Perbaikan')
                    ->rows(5)
                    ->required()
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Status Perbaikan')
                    ->options([
                        'assigned' => 'Ditugaskan',
                        'in_progress' => 'Sedang Dikerjakan',
                        'completed' => 'Selesai',
                    ])
                    ->required(),
            ]);
    }
}