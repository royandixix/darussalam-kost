<?php

namespace App\Filament\Resources\TenantReports\Pages;

use App\Filament\Resources\TenantReports\TenantReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTenantReports extends ListRecords
{
    protected static string $resource = TenantReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
