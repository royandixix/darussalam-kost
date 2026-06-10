<?php

namespace App\Filament\Resources\MaintenanceReports\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MaintenanceReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('photo')
                    ->default(null),
                Select::make('priority')
                    ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'])
                    ->default('medium')
                    ->required(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'assigned' => 'Assigned',
            'in_progress' => 'In progress',
            'completed' => 'Completed',
        ])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
