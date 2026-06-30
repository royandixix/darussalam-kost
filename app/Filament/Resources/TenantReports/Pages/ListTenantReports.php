<?php

namespace App\Filament\Resources\TenantReports\Pages;

use App\Filament\Resources\TenantReports\TenantReportResource;
use Filament\Resources\Pages\ListRecords;

class ListTenantReports extends ListRecords
{
    protected static string $resource = TenantReportResource::class;

    public function getTitle(): string
    {
        return 'Laporan Penghuni';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}