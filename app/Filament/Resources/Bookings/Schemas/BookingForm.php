<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookingForm
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
                    ->disabledOn('edit')
                    ->required(),

                Select::make('room_id')
                    ->label('Kamar')
                    ->relationship('room', 'room_number')
                    ->searchable()
                    ->preload()
                    ->disabledOn('edit')
                    ->required(),

                DatePicker::make('check_in_date')
                    ->label('Tanggal Masuk')
                    ->disabledOn('edit')
                    ->required(),

                TextInput::make('duration_month')
                    ->label('Durasi Sewa')
                    ->numeric()
                    ->suffix(' bulan')
                    ->disabledOn('edit')
                    ->required(),

                TextInput::make('total_price')
                    ->label('Total Kontrak')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabledOn('edit')
                    ->required(),

                Select::make('status')
                    ->label('Status Pemesanan')
                    ->options([
                        'pending' => 'Menunggu Persetujuan',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'completed' => 'Selesai',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
