<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('booking_id')
                    ->label('Pemesanan')
                    ->relationship('booking', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('amount')
                    ->label('Jumlah Pembayaran')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->required(),

                DateTimePicker::make('payment_date')
                    ->label('Tanggal Pembayaran'),

                Select::make('status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Menunggu Verifikasi',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }
}