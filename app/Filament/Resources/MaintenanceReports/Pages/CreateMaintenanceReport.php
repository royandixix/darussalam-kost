<?php

namespace App\Filament\Resources\MaintenanceReports\Pages;

use App\Filament\Resources\MaintenanceReports\MaintenanceReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceReport extends CreateRecord
{
    protected static string $resource = MaintenanceReportResource::class;

    public function getTitle(): string
    {
        return 'Tambah Laporan Perbaikan';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Laporan perbaikan berhasil ditambahkan';
    }
}