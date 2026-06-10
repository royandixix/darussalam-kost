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
                    ->relationship('booking', 'id')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('payment_proof')
                    ->required(),
                DateTimePicker::make('payment_date'),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'verified' => 'Verified', 'rejected' => 'Rejected'])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
