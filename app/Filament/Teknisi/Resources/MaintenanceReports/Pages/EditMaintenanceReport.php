<?php

namespace App\Filament\Teknisi\Resources\MaintenanceReports\Pages;

use App\Filament\Teknisi\Resources\MaintenanceReports\MaintenanceReportResource;
use App\Models\MaintenanceUpdate;
use App\Services\SystemNotificationService;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditMaintenanceReport extends EditRecord
{
    protected static string $resource = MaintenanceReportResource::class;

    private ?string $oldStatus = null;

    public function getTitle(): string
    {
        return 'Update Tugas Perbaikan';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Status tugas berhasil diperbarui';
    }

    protected function beforeSave(): void
    {
        abort_unless((int) $this->record->assigned_technician_id === (int) Auth::id(), 403);
        $this->oldStatus = $this->record->status;
    }

    protected function afterSave(): void
    {
        $note = trim((string) ($this->data['technician_note'] ?? ''));
        $statusChanged = $this->oldStatus !== $this->record->status;

        if ($statusChanged || $note !== '') {
            MaintenanceUpdate::query()->create([
                'maintenance_report_id' => $this->record->id,
                'technician_id' => Auth::id(),
                'note' => $note !== ''
                    ? $note
                    : 'Status perbaikan diperbarui menjadi ' . $this->statusLabel($this->record->status) . '.',
                'status' => $this->record->status,
            ]);
        }

        if ($statusChanged || $note !== '') {
            $this->record->loadMissing(['user', 'room']);

            app(SystemNotificationService::class)->user(
                $this->record->user,
                'Perkembangan perbaikan kamar',
                'Laporan "' . $this->record->title . '" berstatus ' . $this->statusLabel($this->record->status) . ($note !== '' ? '. Catatan: ' . $note : '.'),
                route('user.maintenance.index'),
                $this->record->status === 'completed' ? 'success' : 'info',
            );
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'assigned' => 'Ditugaskan',
            'in_progress' => 'Sedang Dikerjakan',
            'completed' => 'Selesai',
            default => $status,
        };
    }
}
