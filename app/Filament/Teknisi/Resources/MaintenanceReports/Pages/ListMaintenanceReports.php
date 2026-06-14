<?php

namespace App\Filament\Teknisi\Resources\MaintenanceReports\Pages;

use App\Filament\Teknisi\Resources\MaintenanceReports\MaintenanceReportResource;
use Filament\Resources\Pages\ListRecords;

class ListMaintenanceReports extends ListRecords
{
    protected static string $resource = MaintenanceReportResource::class;

    public function getTitle(): string
    {
        return 'Laporan Kerusakan';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}