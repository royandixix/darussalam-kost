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
                        'cod' => 'COD / Bayar di Tempat',
                    ])
                    ->default('bank_transfer')
                    ->live()
                    ->required(),

                TextInput::make('sender_name')
                    ->label('Nama Pengirim')
                    ->maxLength(255)
                    ->visible(fn ($get): bool => $get('payment_method') === 'bank_transfer')
                    ->required(fn ($get): bool => $get('payment_method') === 'bank_transfer'),

                TextInput::make('sender_bank')
                    ->label('Bank / Aplikasi Pengirim')
                    ->maxLength(255)
                    ->visible(fn ($get): bool => $get('payment_method') === 'bank_transfer')
                    ->required(fn ($get): bool => $get('payment_method') === 'bank_transfer'),

                FileUpload::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->disk('public')
                    ->directory('payment-proofs')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->visible(fn ($get): bool => in_array($get('payment_method'), ['bank_transfer', 'qris']))
                    ->required(fn ($get): bool => in_array($get('payment_method'), ['bank_transfer', 'qris'])),

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