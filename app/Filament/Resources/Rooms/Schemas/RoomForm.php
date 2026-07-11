<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
                    ->prefix('Rp')
                    ->placeholder('Contoh: 900.000')
                    ->live(debounce: 300)
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state === null || $state === '') {
                            return;
                        }

                        $number = preg_replace('/[^0-9]/', '', (string) $state);

                        if ($number === '') {
                            $set('price', null);
                            return;
                        }

                        $set('price', number_format((float) $number, 0, ',', '.'));
                    })
                    ->dehydrateStateUsing(function ($state) {
                        if ($state === null || $state === '') {
                            return null;
                        }

                        return preg_replace('/[^0-9]/', '', (string) $state);
                    })
                    ->formatStateUsing(function ($state) {
                        if ($state === null || $state === '') {
                            return null;
                        }

                        $number = preg_replace('/[^0-9]/', '', (string) $state);

                        return number_format((float) $number, 0, ',', '.');
                    })
                    ->extraInputAttributes([
                        'inputmode' => 'numeric',
                    ])
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
                    ->disk('public')
                    ->directory('rooms')
                    ->visibility('public')
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