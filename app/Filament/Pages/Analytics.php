<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;

class Analytics extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Phân tích dữ liệu';
    protected static ?string $title = 'Phân tích mua hàng theo nhân khẩu học';
    protected static ?string $slug = 'analytics';
    protected static ?int $navigationSort = 3;

    // Use the non-static $view to point to our custom blade
    protected string $view = 'filament.pages.analytics';

    public function getViewData(): array
    {
        if (!Cache::has('bytebox_analytics')) {
            \Illuminate\Support\Facades\Artisan::call('analytics:run');
        }
        $data = Cache::get('bytebox_analytics');
        return ['analyticsData' => $data];
    }
}
