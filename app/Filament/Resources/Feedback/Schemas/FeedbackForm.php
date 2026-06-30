<?php

namespace App\Filament\Resources\Feedback\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FeedbackForm
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
                    ->required(),

                Select::make('booking_id')
                    ->label('Pemesanan')
                    ->relationship('booking', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('rating')
                    ->label('Rating')
                    ->options([
                        1 => '1 - Sangat Kurang',
                        2 => '2 - Kurang',
                        3 => '3 - Cukup',
                        4 => '4 - Baik',
                        5 => '5 - Sangat Baik',
                    ])
                    ->required(),

                Textarea::make('comment')
                    ->label('Komentar')
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->label('Tampilkan Feedback')
                    ->default(true),
            ]);
    }
}