<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->defaultThemeMode(\Filament\Enums\ThemeMode::Dark)
            ->colors([
                'primary' => '#f2ca50',
            ])
            ->font('Manrope')
            ->brandLogo(fn () => view('filament.logo'))
            ->brandLogoHeight('4rem')
            ->renderHook(
                \Filament\View\PanelsRenderHook::BODY_START,
                fn (): string => request()->routeIs('filament.admin.auth.login') 
                    ? \Illuminate\Support\Facades\Blade::render('
                        <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 800px; height: 800px; border-radius: 50%; filter: blur(100px); opacity: 0.15; pointer-events: none; background-color: #f2ca50; z-index: 0;"></div>
                        <style>
                            body { background-color: #131313 !important; }
                            .fi-simple-main { background-color: #1c1b1b !important; border: 1px solid rgba(77, 70, 53, 0.2); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4); border-top: 2px solid #f2ca50; position: relative; z-index: 10; border-radius: 1rem; }
                            .fi-btn { background: linear-gradient(135deg, #f2ca50 0%, #d4af37 100%) !important; color: #3c2f00 !important; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; border: none; }
                        </style>
                    ') 
                    : ''
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
