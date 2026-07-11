<?php

namespace App\Filament\Teknisi\Resources\MaintenanceReports\Pages;

use App\Filament\Teknisi\Resources\MaintenanceReports\MaintenanceReportResource;
use App\Models\MaintenanceUpdate;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditMaintenanceReport extends EditRecord
{
    protected static string $resource = MaintenanceReportResource::class;

    protected ?string $oldStatus = null;

    public function getTitle(): string
    {
        return 'Update Laporan Kerusakan';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Status laporan berhasil diperbarui';
    }

    protected function beforeSave(): void
    {
        $this->oldStatus = $this->record->getOriginal('status');
    }

    protected function afterSave(): void
    {
        $technicianNote = trim($this->data['technician_note'] ?? '');

        $statusChanged = $this->oldStatus !== $this->record->status;

        if (! $statusChanged && $technicianNote === '') {
            return;
        }

        $note = $technicianNote !== ''
            ? $technicianNote
            : 'Status laporan diperbarui menjadi ' . $this->getStatusLabel($this->record->status) . '.';

        $lastUpdate = MaintenanceUpdate::query()
            ->where('maintenance_report_id', $this->record->id)
            ->where('technician_id', Auth::id())
            ->latest()
            ->first();

        if (
            $lastUpdate &&
            $lastUpdate->status === $this->record->status &&
            $lastUpdate->note === $note
        ) {
            return;
        }

        MaintenanceUpdate::create([
            'maintenance_report_id' => $this->record->id,
            'technician_id' => Auth::id(),
            'note' => $note,
            'status' => $this->record->status,
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    private function getStatusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu',
            'assigned' => 'Ditugaskan',
            'in_progress' => 'Sedang Dikerjakan',
            'completed' => 'Selesai',
            default => $status,
        };
    }
}