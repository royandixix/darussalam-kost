<?php

namespace App\Filament\Teknisi\Resources\MaintenanceReports\Schemas;

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
                    ->label('Nama Penghuni')
                    ->relationship('user', 'name')
                    ->disabled()
                    ->dehydrated(false),

                Select::make('room_id')
                    ->label('Kamar')
                    ->relationship('room', 'room_number')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('title')
                    ->label('Judul Kerusakan')
                    ->disabled()
                    ->dehydrated(false),

                Textarea::make('description')
                    ->label('Deskripsi Kerusakan')
                    ->disabled()
                    ->dehydrated(false)
                    ->rows(4)
                    ->columnSpanFull(),

                FileUpload::make('photo')
                    ->label('Foto Kerusakan')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->disabled()
                    ->dehydrated(false),

                Select::make('priority')
                    ->label('Prioritas')
                    ->options([
                        'low' => 'Rendah',
                        'medium' => 'Sedang',
                        'high' => 'Tinggi',
                    ])
                    ->disabled()
                    ->dehydrated(false),

                Select::make('status')
                    ->label('Status Pengerjaan')
                    ->options([
                        'assigned' => 'Ditugaskan',
                        'in_progress' => 'Sedang Dikerjakan',
                        'completed' => 'Selesai',
                    ])
                    ->required(),

                Textarea::make('technician_note')
                    ->label('Catatan Teknisi')
                    ->placeholder('Tuliskan hasil pemeriksaan atau pekerjaan yang sudah dilakukan.')
                    ->rows(4)
                    ->dehydrated(false)
                    ->columnSpanFull(),
            ]);
    }
}
