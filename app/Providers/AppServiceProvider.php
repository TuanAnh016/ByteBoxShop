<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            // Force HTTPS for all generated URLs (needed behind Render's reverse proxy)
            // This also fixes Livewire 3 / Filament login AJAX requests
            URL::forceScheme('https');

            // Force the root URL so Livewire generates correct update endpoints
            // Without this, Livewire POSTs to http:// which browsers block as mixed content
            $appUrl = config('app.url');
            if ($appUrl) {
                URL::forceRootUrl(str_replace('http://', 'https://', $appUrl));
            }

            // Ensure session cookies are sent over HTTPS only
            config([
                'session.secure'    => true,
                'session.same_site' => 'lax',
            ]);
        }
    }
}
