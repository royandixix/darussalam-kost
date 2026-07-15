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
                    ->options(function (): array {
                        return MaintenanceReport::query()
                            ->with(['user', 'room'])
                            ->where(function ($query): void {
                                $query
                                    ->where('assigned_technician_id', Auth::id())
                                    ->orWhereNull('assigned_technician_id');
                            })
                            ->whereIn('status', [
                                'pending',
                                'assigned',
                                'in_progress',
                            ])
                            ->latest()
                            ->get()
                            ->mapWithKeys(
                                fn (MaintenanceReport $report): array => [
                                    $report->id =>
                                        $report->title
                                        . ' - '
                                        . ($report->user?->name ?? 'Penghuni')
                                        . ' - Kamar '
                                        . ($report->room?->room_number ?? '-')
                                        . ' - '
                                        . match ($report->status) {
                                            'pending' => 'Belum Ditugaskan',
                                            'assigned' => 'Ditugaskan',
                                            'in_progress' => 'Sedang Dikerjakan',
                                            default => $report->status,
                                        },
                                ]
                            )
                            ->all();
                    })
                    ->searchable()
                    ->required(),

                Hidden::make('technician_id')
                    ->default(fn (): ?int => Auth::id()),

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
                    ->default('in_progress')
                    ->required(),
            ]);
    }
}