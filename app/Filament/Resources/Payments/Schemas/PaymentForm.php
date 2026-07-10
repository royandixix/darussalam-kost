<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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

                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'bank_transfer' => 'Transfer Bank',
                        'qris' => 'QRIS',
                    ])
                    ->default('bank_transfer')
                    ->required(),

                TextInput::make('sender_name')
                    ->label('Nama Pengirim')
                    ->maxLength(255),

                TextInput::make('sender_bank')
                    ->label('Bank / Aplikasi Pengirim')
                    ->maxLength(255),

                FileUpload::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->disk('public')
                    ->directory('payment-proofs')
                    ->visibility('public')
                    ->maxSize(2048)
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

                Textarea::make('note')
                    ->label('Catatan Admin')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}