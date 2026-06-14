<?php

namespace App\Filament\Teknisi\Resources\MaintenanceReports\Pages;

use App\Filament\Teknisi\Resources\MaintenanceReports\MaintenanceReportResource;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceReport extends EditRecord
{
    protected static string $resource = MaintenanceReportResource::class;

    public function getTitle(): string
    {
        return 'Update Laporan Kerusakan';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Status laporan berhasil diperbarui';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}