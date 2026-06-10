<?php

namespace App\Filament\Resources\Rooms\Schemas;

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
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('capacity')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('size')
                    ->numeric()
                    ->default(null),
                Textarea::make('facilities')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('photo')
                    ->default(null),
                Select::make('status')
                    ->options(['available' => 'Available', 'occupied' => 'Occupied', 'maintenance' => 'Maintenance'])
                    ->default('available')
                    ->required(),
            ]);
    }
}
