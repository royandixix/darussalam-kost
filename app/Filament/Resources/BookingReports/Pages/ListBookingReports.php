<?php

namespace App\Filament\Resources\BookingReports\Pages;

use App\Filament\Resources\BookingReports\BookingReportResource;
use Filament\Resources\Pages\ListRecords;

class ListBookingReports extends ListRecords
{
    protected static string $resource = BookingReportResource::class;

    public function getTitle(): string
    {
        return 'Laporan Maintenance';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}