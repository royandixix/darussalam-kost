<?php

namespace App\Filament\Resources\MaintenanceReports\Schemas;

use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MaintenanceReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Penghuni')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('room_id')
                    ->label('Kamar')
                    ->relationship('room', 'room_number')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('assigned_technician_id')
                    ->label('Teknisi yang Ditugaskan')
                    ->options(fn (): array => User::query()
                        ->where('role', 'teknisi')
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->preload()
                    ->nullable(),

                TextInput::make('title')
                    ->label('Judul Laporan')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Deskripsi Kerusakan')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                FileUpload::make('photo')
                    ->label('Foto Kerusakan')
                    ->image()
                    ->disk('public')
                    ->directory('maintenance-reports')
                    ->visibility('public')
                    ->maxSize(2048),

                Select::make('priority')
                    ->label('Prioritas')
                    ->options([
                        'low' => 'Rendah',
                        'medium' => 'Sedang',
                        'high' => 'Tinggi',
                    ])
                    ->default('medium')
                    ->required(),

                Select::make('status')
                    ->label('Status Laporan')
                    ->options([
                        'pending' => 'Menunggu',
                        'assigned' => 'Ditugaskan',
                        'in_progress' => 'Sedang Dikerjakan',
                        'completed' => 'Selesai',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
