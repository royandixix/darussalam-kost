<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class RoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('room_number')
                    ->label('Nomor Kamar')
                    ->required(),

                TextInput::make('price')
                    ->label('Harga Sewa')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('capacity')
                    ->label('Kapasitas Penghuni')
                    ->numeric()
                    ->default(1)
                    ->required(),

                TextInput::make('size')
                    ->label('Ukuran Kamar (m²)')
                    ->numeric(),

                Textarea::make('facilities')
                    ->label('Fasilitas')
                    ->columnSpanFull(),

                FileUpload::make('photo')
                    ->label('Foto Kamar')
                    ->image()
                    ->directory('rooms')
                    ->imagePreviewHeight('120')
                    ->maxSize(2048),

                Select::make('status')
                    ->label('Status Kamar')
                    ->options([
                        'available' => 'Tersedia',
                        'occupied' => 'Terisi',
                        'maintenance' => 'Perbaikan',
                    ])
                    ->default('available')
                    ->required(),
            ]);
    }
}