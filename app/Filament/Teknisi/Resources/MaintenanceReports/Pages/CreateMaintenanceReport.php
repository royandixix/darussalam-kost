<?php

namespace App\Filament\Teknisi\Resources\MaintenanceReports\Pages;

use App\Filament\Teknisi\Resources\MaintenanceReports\MaintenanceReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceReport extends CreateRecord
{
    protected static string $resource = MaintenanceReportResource::class;

    public function getTitle(): string
    {
        return 'Tambah Laporan Kerusakan';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Laporan kerusakan berhasil ditambahkan';
    }
}