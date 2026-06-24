<?php

namespace App\Filament\Resources\TenantReports\Pages;

use App\Filament\Resources\TenantReports\TenantReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenantReport extends EditRecord
{
    protected static string $resource = TenantReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
