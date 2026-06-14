<?php

namespace App\Filament\Teknisi\Resources\MaintenanceUpdates\Pages;

use App\Filament\Teknisi\Resources\MaintenanceUpdates\MaintenanceUpdateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaintenanceUpdates extends ListRecords
{
    protected static string $resource = MaintenanceUpdateResource::class;

    public function getTitle(): string
    {
        return 'Catatan Perbaikan';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Catatan'),
        ];
    }
}