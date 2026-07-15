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
                    ->disabledOn('edit')
                    ->required(),

                TextInput::make('amount')
                    ->label('Jumlah Pembayaran')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabledOn('edit')
                    ->required(),

                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'bank_transfer' => 'Transfer Bank',
                        'qris' => 'QRIS',
                        'cod' => 'COD / Bayar di Tempat',
                    ])
                    ->disabledOn('edit')
                    ->required(),

                TextInput::make('sender_name')
                    ->label('Nama Pengirim')
                    ->disabledOn('edit'),

                TextInput::make('sender_bank')
                    ->label('Bank / Aplikasi Pengirim')
                    ->disabledOn('edit'),

                FileUpload::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->disabledOn('edit'),

                DateTimePicker::make('payment_date')
                    ->label('Tanggal Pembayaran')
                    ->disabledOn('edit'),

                Select::make('status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Menunggu Verifikasi',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                    ])
                    ->required(),

                Textarea::make('note')
                    ->label('Catatan Admin')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
