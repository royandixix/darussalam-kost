<?php

namespace App\Providers\Filament;

use App\Filament\Teknisi\Pages\TeknisiDashboard;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
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
            ->brandName(fn () => Auth::check() ? 'Teknisi • ' . Auth::user()->name : 'Teknisi Kost Darussalam')
            ->favicon(asset('images/favicon.png'))
            ->brandLogoHeight('2.5rem')
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'gray' => Color::Zinc,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->font('Plus Jakarta Sans')
            ->defaultThemeMode(ThemeMode::Dark)
            ->sidebarCollapsibleOnDesktop()
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn () => view('filament.teknisi.login-header')
            )
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
                TeknisiDashboard::class,
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