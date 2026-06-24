<?php

namespace App\Filament\Resources\PaymentReports\Pages;

use App\Filament\Resources\PaymentReports\PaymentReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPaymentReport extends EditRecord
{
    protected static string $resource = PaymentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
