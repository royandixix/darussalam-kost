<?php

namespace App\Filament\Teknisi\Resources\MaintenanceUpdates\Pages;

use App\Filament\Teknisi\Resources\MaintenanceUpdates\MaintenanceUpdateResource;
use App\Models\MaintenanceReport;
use App\Services\SystemNotificationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMaintenanceUpdate extends CreateRecord
{
    protected static string $resource = MaintenanceUpdateResource::class;

    public function getTitle(): string
    {
        return 'Tambah Catatan Perbaikan';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $report = MaintenanceReport::query()
            ->whereKey($data['maintenance_report_id'])
            ->where('assigned_technician_id', Auth::id())
            ->firstOrFail();

        $data['technician_id'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        $report = $this->record->report;
        $report?->update(['status' => $this->record->status]);
        $report?->loadMissing(['user', 'room']);

        app(SystemNotificationService::class)->user(
            $report?->user,
            'Perkembangan perbaikan kamar',
            'Laporan "' . ($report?->title ?? '-') . '" diperbarui: ' . $this->record->note,
            route('user.maintenance.index'),
            $this->record->status === 'completed' ? 'success' : 'info',
        );
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Catatan perbaikan berhasil ditambahkan';
    }
}
