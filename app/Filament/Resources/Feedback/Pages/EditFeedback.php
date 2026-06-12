<?php

namespace App\Filament\Resources\Feedback\Pages;

use App\Filament\Resources\Feedback\FeedbackResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFeedback extends EditRecord
{
    protected static string $resource = FeedbackResource::class;

    public function getTitle(): string
    {
        return 'Edit Feedback';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Feedback berhasil diperbarui';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Feedback')
                ->modalDescription('Apakah Anda yakin ingin menghapus feedback ini?')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }
}