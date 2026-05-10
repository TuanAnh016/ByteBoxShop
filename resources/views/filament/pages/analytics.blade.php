<x-filament-panels::page>
    <div class="space-y-8">

        @if(!$analyticsData)
        {{-- No data state --}}
        <div class="fi-wi-stats-overview-stat rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div style="width: 64px; height: 64px;" class="text-gray-400 mb-4">
                    <x-heroicon-o-chart-bar />
                </div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Chưa có dữ liệu phân tích</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Chạy lệnh sau trong terminal để tạo báo cáo:</p>
                <code class="px-4 py-2 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm font-mono text-amber-600">php artisan analytics:run</code>
            </div>
        </div>
        @else

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @php
                $summary = $analyticsData['summary'];
                $cards = [
                    ['label' => 'Tổng đơn hàng', 'value' => number_format($summary['total_orders']), 'icon' => 'heroicon-o-shopping-bag', 'color' => 'text-green-500'],
                    ['label' => 'Doanh thu', 'value' => '$' . number_format($summary['total_revenue'], 2), 'icon' => 'heroicon-o-currency-dollar', 'color' => 'text-amber-500'],
                    ['label' => 'Khách mua hàng', 'value' => number_format($summary['unique_buyers']), 'icon' => 'heroicon-o-users', 'color' => 'text-blue-500'],
                    ['label' => 'Tổng người dùng', 'value' => number_format($summary['total_users']), 'icon' => 'heroicon-o-user-group', 'color' => 'text-purple-500'],
                ];
            @endphp
            @foreach($cards as $card)
            <div class="rounded-xl bg-white dark:bg-gray-900 p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 flex items-center gap-4">
                <div class="{{ $card['color'] }}" style="width: 40px; height: 40px; flex-shrink: 0;">
                    <x-dynamic-component :component="$card['icon']" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $card['value'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $card['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Top Demographics Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Gender Distribution --}}
            <div class="rounded-xl bg-white dark:bg-gray-900 p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
                    <div style="width: 20px; height: 20px;" class="text-amber-500"><x-heroicon-o-users /></div>
                    Phân bổ Doanh thu theo Giới tính
                </h3>
                <div class="h-[300px]">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            {{-- Age Group Distribution --}}
            <div class="rounded-xl bg-white dark:bg-gray-900 p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
                    <div style="width: 20px; height: 20px;" class="text-blue-500"><x-heroicon-o-chart-bar /></div>
                    Doanh thu & Đơn hàng theo Nhóm tuổi
                </h3>
                <div class="h-[300px]">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Demographic vs Category Preferences (New Bar Charts) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Gender Category Preference Chart --}}
            <div class="rounded-xl bg-white dark:bg-gray-900 p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
                    <div style="width: 20px; height: 20px;" class="text-green-500"><x-heroicon-o-tag /></div>
                    Doanh thu Danh mục theo Giới tính
                </h3>
                <div class="h-[350px]">
                    <canvas id="genderCategoryChart"></canvas>
                </div>
            </div>

            {{-- Age Category Preference Chart --}}
            <div class="rounded-xl bg-white dark:bg-gray-900 p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
                    <div style="width: 20px; height: 20px;" class="text-purple-500"><x-heroicon-o-adjustments-horizontal /></div>
                    Doanh thu Danh mục theo Nhóm tuổi
                </h3>
                <div class="h-[350px]">
                    <canvas id="ageCategoryChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Top 10 Products (New Section) --}}
        <div class="rounded-xl bg-white dark:bg-gray-900 p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
                <div style="width: 20px; height: 20px;" class="text-amber-600"><x-heroicon-o-fire /></div>
                Top 10 Sản phẩm bán chạy nhất
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="py-3 font-semibold text-gray-600 dark:text-gray-400">Sản phẩm</th>
                            <th class="py-3 font-semibold text-gray-600 dark:text-gray-400 text-center">Đã bán</th>
                            <th class="py-3 font-semibold text-gray-600 dark:text-gray-400 text-right">Doanh thu</th>
                            <th class="py-3 font-semibold text-gray-600 dark:text-gray-400 w-48 text-right">Tỷ trọng</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @php $maxRev = !empty($analyticsData['top_products']) ? max(array_column($analyticsData['top_products'], 'revenue')) : 0; @endphp
                        @foreach($analyticsData['top_products'] as $product)
                        <tr>
                            <td class="py-4 font-medium text-gray-800 dark:text-gray-200">{{ $product['name'] }}</td>
                            <td class="py-4 text-center">{{ $product['sold'] }}</td>
                            <td class="py-4 text-right font-bold text-amber-500">${{ number_format($product['revenue'], 2) }}</td>
                            <td class="py-4 text-right">
                                <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-1.5">
                                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $maxRev > 0 ? ($product['revenue'] / $maxRev * 100) : 0 }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-right text-xs text-gray-400">
            Dữ liệu tạo lúc: {{ $analyticsData['generated_at'] }} · Làm mới: <code>php artisan analytics:run --force</code>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#d1d5db' : '#374151';
            const gridColor = isDark ? '#374151' : '#e5e7eb';

            // Chart Colors
            const colors = {
                blue: '#3b82f6',
                pink: '#ec4899',
                purple: '#a78bfa',
                amber: '#f59e0b',
                green: '#10b981',
                slate: '#64748b'
            };

            const chartDefaults = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { labels: { color: textColor, font: { size: 12 } } } 
                },
                scales: {
                    x: { ticks: { color: textColor }, grid: { color: gridColor } },
                    y: { ticks: { color: textColor }, grid: { color: gridColor } }
                }
            };

            // 1. Gender Distribution Chart
            const genderData = @json($analyticsData['gender']);
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: genderData.labels,
                    datasets: [{
                        data: genderData.revenue,
                        backgroundColor: [colors.blue, colors.pink, colors.purple, colors.slate],
                        borderWidth: 2,
                        borderColor: isDark ? '#111827' : '#ffffff'
                    }]
                },
                options: {
                    ...chartDefaults,
                    plugins: {
                        legend: { position: 'bottom', labels: { color: textColor } },
                        tooltip: { callbacks: { label: (ctx) => ctx.label + ': $' + ctx.parsed.toFixed(2) } }
                    }
                }
            });

            // 2. Age Group Chart
            const ageData = @json($analyticsData['age_groups']);
            new Chart(document.getElementById('ageChart'), {
                type: 'bar',
                data: {
                    labels: ageData.labels,
                    datasets: [
                        { label: 'Đơn hàng', data: ageData.orders, backgroundColor: colors.blue, yAxisID: 'y' },
                        { label: 'Doanh thu ($)', data: ageData.revenue, backgroundColor: colors.amber, yAxisID: 'y1' }
                    ]
                },
                options: {
                    ...chartDefaults,
                    scales: {
                        ...chartDefaults.scales,
                        y: { ...chartDefaults.scales.y, title: { display: true, text: 'Đơn hàng', color: textColor } },
                        y1: { type: 'linear', position: 'right', ticks: { color: colors.amber }, grid: { drawOnChartArea: false }, title: { display: true, text: 'Doanh thu ($)', color: colors.amber } }
                    }
                }
            });

            // 3. Gender vs Category Preference Chart
            const genCatRaw = @json($analyticsData['category_by_gender']);
            const allCats = [...new Set(Object.values(genCatRaw).flatMap(arr => arr.map(i => i.category)))];
            const genderDatasets = Object.keys(genCatRaw).map((gender, idx) => ({
                label: gender,
                data: allCats.map(cat => {
                    const item = genCatRaw[gender].find(i => i.category === cat);
                    return item ? item.revenue : 0;
                }),
                backgroundColor: [colors.blue, colors.pink, colors.purple][idx % 3]
            }));

            new Chart(document.getElementById('genderCategoryChart'), {
                type: 'bar',
                data: { labels: allCats, datasets: genderDatasets },
                options: {
                    ...chartDefaults,
                    indexAxis: 'y',
                    scales: {
                        x: { ...chartDefaults.scales.x, stacked: false, title: { display: true, text: 'Doanh thu ($)', color: textColor } },
                        y: { ...chartDefaults.scales.y, stacked: false }
                    }
                }
            });

            // 4. Age vs Category Preference Chart
            const ageCatRaw = @json($analyticsData['category_by_age']);
            const ageGroups = Object.keys(ageCatRaw);
            const ageDatasets = allCats.map((cat, idx) => ({
                label: cat,
                data: ageGroups.map(group => {
                    const item = ageCatRaw[group].find(i => i.category === cat);
                    return item ? item.revenue : 0;
                }),
                backgroundColor: `hsla(${idx * 45}, 70%, 50%, 0.8)`
            }));

            new Chart(document.getElementById('ageCategoryChart'), {
                type: 'bar',
                data: { labels: ageGroups, datasets: ageDatasets },
                options: {
                    ...chartDefaults,
                    scales: {
                        x: { ...chartDefaults.scales.x, stacked: true },
                        y: { ...chartDefaults.scales.y, stacked: true, title: { display: true, text: 'Doanh thu tích lũy ($)', color: textColor } }
                    }
                }
            });
        });
        </script>
        @endif
    </div>
</x-filament-panels::page>
