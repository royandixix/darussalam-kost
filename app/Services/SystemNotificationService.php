<?php

namespace App\Services;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class SystemNotificationService
{
    public function admins(string $title, string $body, ?string $url = null, string $status = 'info'): void
    {
        $admins = User::query()->where('role', 'admin')->get();

        $this->send($admins, $title, $body, $url, $status);
    }

    public function technicians(string $title, string $body, ?string $url = null, string $status = 'info'): void
    {
        $technicians = User::query()->where('role', 'teknisi')->get();

        $this->send($technicians, $title, $body, $url, $status);
    }

    public function user(?User $user, string $title, string $body, ?string $url = null, string $status = 'info'): void
    {
        if (! $user) {
            return;
        }

        $this->send(new Collection([$user]), $title, $body, $url, $status);
    }

    public function technician(?User $technician, string $title, string $body, ?string $url = null, string $status = 'info'): void
    {
        if (! $technician || $technician->role !== 'teknisi') {
            return;
        }

        $this->send(new Collection([$technician]), $title, $body, $url, $status);
    }

    private function send(Collection $recipients, string $title, string $body, ?string $url, string $status): void
    {
        if ($recipients->isEmpty()) {
            return;
        }

        $notification = Notification::make()
            ->title($title)
            ->body($body)
            ->viewData([
                'url' => $url,
            ]);

        if ($url) {
            $notification->actions([
                Action::make('open')
                    ->label('Buka')
                    ->button()
                    ->url($url)
                    ->markAsRead(),
            ]);
        }

        match ($status) {
            'success' => $notification->success(),
            'warning' => $notification->warning(),
            'danger' => $notification->danger(),
            default => $notification->info(),
        };

        $notification->sendToDatabase($recipients, isEventDispatched: true);
    }
}
