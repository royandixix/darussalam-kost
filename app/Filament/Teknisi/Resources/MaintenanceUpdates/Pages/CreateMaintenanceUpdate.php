<?php

namespace App\Filament\Teknisi\Resources\MaintenanceUpdates\Pages;

use App\Filament\Teknisi\Resources\MaintenanceUpdates\MaintenanceUpdateResource;
use App\Models\MaintenanceReport;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CreateMaintenanceUpdate extends CreateRecord
{
    protected static string $resource = MaintenanceUpdateResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $report = MaintenanceReport::query()
            ->lockForUpdate()
            ->findOrFail($data['maintenance_report_id']);

        if (
            $report->assigned_technician_id !== null
            && (int) $report->assigned_technician_id !== (int) Auth::id()
        ) {
            throw ValidationException::withMessages([
                'maintenance_report_id' =>
                    'Laporan ini sudah ditugaskan kepada teknisi lain.',
            ]);
        }

        if ($report->assigned_technician_id === null) {
            $report->update([
                'assigned_technician_id' => Auth::id(),
                'status' => 'assigned',
            ]);
        }

        $data['technician_id'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        $update = $this->record;

        $report = MaintenanceReport::query()
            ->find($update->maintenance_report_id);

        if ($report) {
            $report->update([
                'assigned_technician_id' => Auth::id(),
                'status' => $update->status,
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}