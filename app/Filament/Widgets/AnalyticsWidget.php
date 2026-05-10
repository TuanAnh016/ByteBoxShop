<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class AnalyticsWidget extends BaseWidget
{
    protected static ?int $sort = 10;
    
    // Đặt 4 cột để hiển thị trên cùng 1 hàng ngang
    protected int | string | array $columnSpan = 'full';
    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $data = Cache::get('bytebox_analytics');

        if (!$data) {
            return [
                Stat::make('Dữ liệu phân tích', 'Chưa có')
                    ->description('Chạy: php artisan analytics:run')
                    ->color('warning')
                    ->icon('heroicon-o-chart-bar'),
            ];
        }

        $summary = $data['summary'];

        // Best gender by revenue
        $genderLabels  = $data['gender']['labels'] ?? [];
        $genderRevenue = $data['gender']['revenue'] ?? [];
        $topGender     = 'N/A';
        if (!empty($genderRevenue)) {
            $maxIdx    = array_keys($genderRevenue, max($genderRevenue))[0];
            $topGender = $genderLabels[$maxIdx] ?? 'N/A';
        }

        // Best age group by revenue
        $ageLabels   = $data['age_groups']['labels'] ?? [];
        $ageRevenue  = $data['age_groups']['revenue'] ?? [];
        $topAgeGroup = 'N/A';
        if (!empty($ageRevenue)) {
            $maxIdx      = array_keys($ageRevenue, max($ageRevenue))[0];
            $topAgeGroup = $ageLabels[$maxIdx] ?? 'N/A';
        }

        return [
            Stat::make('Tổng đơn hàng', number_format($summary['total_orders']))
                ->description($summary['unique_buyers'] . ' khách hàng đã mua')
                ->color('success')
                ->icon('heroicon-o-shopping-bag'),

            Stat::make('Tổng doanh thu', '$' . number_format($summary['total_revenue'], 2))
                ->description('Từ tất cả đơn hàng hợp lệ')
                ->color('primary')
                ->icon('heroicon-o-currency-dollar'),

            Stat::make('Giới tính mua nhiều nhất', $topGender)
                ->description('Theo doanh thu')
                ->color('info')
                ->icon('heroicon-o-users'),

            Stat::make('Nhóm tuổi mua nhiều nhất', $topAgeGroup)
                ->description('Theo doanh thu')
                ->color('warning')
                ->icon('heroicon-o-chart-pie'),
        ];
    }
}
