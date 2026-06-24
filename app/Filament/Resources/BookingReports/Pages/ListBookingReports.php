<?php

namespace App\Filament\Resources\BookingReports\Pages;

use App\Filament\Resources\BookingReports\BookingReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookingReports extends ListRecords
{
    protected static string $resource = BookingReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
