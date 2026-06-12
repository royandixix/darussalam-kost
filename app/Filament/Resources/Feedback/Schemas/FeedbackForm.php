<?php

namespace App\Filament\Resources\Feedback\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FeedbackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

                TextInput::make('rating')
                    ->label('Penilaian')
                    ->numeric(),

                Textarea::make('message')
                    ->label('Pesan')
                    ->required(),
            ]);
    }
}