<?php

namespace App\Filament\Resources\BookingReports\Pages;

use App\Filament\Resources\BookingReports\BookingReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBookingReport extends EditRecord
{
    protected static string $resource = BookingReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
