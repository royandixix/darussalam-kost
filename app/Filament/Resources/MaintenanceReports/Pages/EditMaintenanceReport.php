<?php

namespace App\Filament\Resources\MaintenanceReports\Pages;

use App\Filament\Resources\MaintenanceReports\MaintenanceReportResource;
use App\Filament\Teknisi\Resources\MaintenanceReports\MaintenanceReportResource as TechnicianMaintenanceReportResource;
use App\Models\MaintenanceUpdate;
use App\Services\SystemNotificationService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditMaintenanceReport extends EditRecord
{
    protected static string $resource = MaintenanceReportResource::class;

    private ?int $oldTechnicianId = null;
    private ?string $oldStatus = null;

    public function getTitle(): string
    {
        return 'Kelola Laporan Perbaikan';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Laporan perbaikan berhasil diperbarui';
    }

    protected function beforeSave(): void
    {
        $this->oldTechnicianId = $this->record->assigned_technician_id;
        $this->oldStatus = $this->record->status;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! empty($data['assigned_technician_id']) && ($data['status'] ?? 'pending') === 'pending') {
            $data['status'] = 'assigned';
        }

        $status = $data['status'] ?? 'pending';
        $requiresTechnician = in_array($status, ['assigned', 'in_progress', 'completed'], true);

        if ($requiresTechnician && empty($data['assigned_technician_id'])) {
            throw ValidationException::withMessages([
                'assigned_technician_id' => 'Pilih teknisi sebelum mengubah status laporan menjadi ditugaskan, sedang dikerjakan, atau selesai.',
            ]);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->loadMissing(['user', 'room', 'assignedTechnician']);

        $technicianChanged = $this->oldTechnicianId !== $this->record->assigned_technician_id;
        $statusChanged = $this->oldStatus !== $this->record->status;

        if ($technicianChanged && $this->record->assignedTechnician) {
            app(SystemNotificationService::class)->technician(
                $this->record->assignedTechnician,
                'Tugas perbaikan baru',
                'Anda ditugaskan menangani ' . $this->record->title . ' di kamar ' . ($this->record->room?->room_number ?? '-') . '.',
                TechnicianMaintenanceReportResource::getUrl(
                    'edit',
                    ['record' => $this->record],
                    panel: 'teknisi',
                ),
                'warning',
            );
        }

        if (($technicianChanged || $statusChanged) && $this->record->status !== 'pending') {
            MaintenanceUpdate::query()->create([
                'maintenance_report_id' => $this->record->id,
                'technician_id' => $this->record->assigned_technician_id,
                'note' => $technicianChanged
                    ? 'Admin menugaskan teknisi ' . ($this->record->assignedTechnician?->name ?? '-') . '.'
                    : 'Admin memperbarui status menjadi ' . $this->statusLabel($this->record->status) . '.',
                'status' => $this->record->status,
            ]);
        }

        if ($technicianChanged || $statusChanged) {
            app(SystemNotificationService::class)->user(
                $this->record->user,
                'Laporan perbaikan diperbarui',
                'Laporan "' . $this->record->title . '" sekarang berstatus ' . $this->statusLabel($this->record->status) . '.',
                route('user.maintenance.index'),
                $this->record->status === 'completed' ? 'success' : 'info',
            );
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->visible(fn (): bool => $this->record->status === 'pending')
                ->modalHeading('Hapus Laporan Perbaikan')
                ->modalDescription('Hanya laporan yang belum diproses yang dapat dihapus.')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }

    private function statusLabel(string $status): string
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
