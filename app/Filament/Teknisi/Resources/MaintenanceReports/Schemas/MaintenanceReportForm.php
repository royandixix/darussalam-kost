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
                    ->disabled(),

                Select::make('room_id')
                    ->label('Kamar')
                    ->relationship('room', 'room_number')
                    ->disabled(),

                TextInput::make('title')
                    ->label('Judul Kerusakan')
                    ->disabled(),

                Textarea::make('description')
                    ->label('Deskripsi Kerusakan')
                    ->disabled()
                    ->columnSpanFull(),

                FileUpload::make('photo')
                    ->label('Foto Kerusakan')
                    ->image()
                    ->disabled(),

                Select::make('priority')
                    ->label('Prioritas')
                    ->options([
                        'low' => 'Rendah',
                        'medium' => 'Sedang',
                        'high' => 'Tinggi',
                    ])
                    ->disabled(),

                Select::make('status')
                    ->label('Status Pengerjaan')
                    ->options([
                        'pending' => 'Menunggu',
                        'assigned' => 'Ditugaskan',
                        'in_progress' => 'Sedang Dikerjakan',
                        'completed' => 'Selesai',
                    ])
                    ->required(),
            ]);
    }
}