<?php

namespace App\Providers\Filament;

use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TeknisiPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('teknisi')
            ->path('teknisi')
            ->login()
            ->profile()

            ->brandName(function () {
                $user = Auth::user();

                if ($user) {
                    return 'Teknisi • ' . $user->name;
                }

                return 'Panel Teknisi';
            })

            ->favicon(asset('images/favicon.png'))

            ->colors([
                'danger'  => Color::Rose,
                'gray'    => Color::Zinc,
                'info'    => Color::Blue,
                'primary' => Color::Amber,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])

            ->font('Plus Jakarta Sans')

            ->defaultThemeMode(ThemeMode::Dark)

            ->sidebarCollapsibleOnDesktop()

            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Layanan Perbaikan')
                    ->icon('heroicon-o-wrench-screwdriver'),

                NavigationGroup::make()
                    ->label('Akun')
                    ->icon('heroicon-o-user-circle')
                    ->collapsed(),
            ])

            ->discoverResources(
                in: app_path('Filament/Teknisi/Resources'),
                for: 'App\\Filament\\Teknisi\\Resources',
            )

            ->discoverPages(
                in: app_path('Filament/Teknisi/Pages'),
                for: 'App\\Filament\\Teknisi\\Pages',
            )

            ->pages([
                Dashboard::class,
            ])

            ->discoverWidgets(
                in: app_path('Filament/Teknisi/Widgets'),
                for: 'App\\Filament\\Teknisi\\Widgets',
            )

            ->widgets([
                AccountWidget::class,
            ])

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestsDuringMaintenance::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}