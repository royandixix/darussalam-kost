<?php

namespace App\Filament\Resources\Tenants\Schemas;

use App\Models\Room;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Penghuni')
                    ->required(),

                TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email(),

                Select::make('room_id')
                    ->label('Kamar')
                    ->options(
                        Room::pluck('room_number', 'id')
                    )
                    ->searchable()
                    ->required(),

                DatePicker::make('check_in_date')
                    ->label('Tanggal Masuk')
                    ->required(),

                Select::make('status')
                    ->label('Status Penghuni')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }
}
