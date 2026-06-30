<?php

namespace App\Filament\Resources\PaymentReports\Pages;

use App\Filament\Resources\PaymentReports\PaymentReportResource;
use Filament\Resources\Pages\ListRecords;

class ListPaymentReports extends ListRecords
{
    protected static string $resource = PaymentReportResource::class;

    public function getTitle(): string
    {
        return 'Laporan Pembayaran';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}