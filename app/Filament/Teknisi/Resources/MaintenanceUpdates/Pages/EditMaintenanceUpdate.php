<?php

namespace App\Filament\Teknisi\Resources\MaintenanceUpdates\Pages;

use App\Filament\Teknisi\Resources\MaintenanceUpdates\MaintenanceUpdateResource;
use App\Services\SystemNotificationService;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditMaintenanceUpdate extends EditRecord
{
    protected static string $resource = MaintenanceUpdateResource::class;

    protected function beforeSave(): void
    {
        abort_unless((int) $this->record->technician_id === (int) Auth::id(), 403);
    }

    protected function afterSave(): void
    {
        $report = $this->record->report;
        $report?->update(['status' => $this->record->status]);
        $report?->loadMissing('user');

        app(SystemNotificationService::class)->user(
            $report?->user,
            'Catatan perbaikan diperbarui',
            $this->record->note,
            route('user.maintenance.index'),
            $this->record->status === 'completed' ? 'success' : 'info',
        );
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Catatan perbaikan berhasil diperbarui';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
