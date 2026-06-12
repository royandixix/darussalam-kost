<?php

namespace App\Filament\Resources\Feedback\Pages;

use App\Filament\Resources\Feedback\FeedbackResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFeedback extends CreateRecord
{
    protected static string $resource = FeedbackResource::class;

    public function getTitle(): string
    {
        return 'Tambah Feedback';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Feedback berhasil ditambahkan';
    }
}