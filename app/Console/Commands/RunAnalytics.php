<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RunAnalytics extends Command
{
    protected $signature = 'analytics:run {--force : Force refresh even if cache exists}';
    protected $description = 'Run Python analytics script and cache the results';

    public function handle(): int
    {
        $cacheKey = 'bytebox_analytics';
        $cacheTtl = 60 * 60 * 6; // 6 hours

        if (!$this->option('force') && Cache::has($cacheKey)) {
            $this->info('Analytics data already cached. Use --force to refresh.');
            return self::SUCCESS;
        }

        $scriptPath = base_path('scripts/analytics.py');

        if (!file_exists($scriptPath)) {
            $this->error('Analytics script not found: ' . $scriptPath);
            return self::FAILURE;
        }

        // Pass DB credentials as environment variables
        $env = [
            'DB_HOST'     => config('database.connections.mysql.host', '127.0.0.1'),
            'DB_PORT'     => config('database.connections.mysql.port', '3306'),
            'DB_DATABASE' => config('database.connections.mysql.database', 'bytebox'),
            'DB_USERNAME' => config('database.connections.mysql.username', 'root'),
            'DB_PASSWORD' => config('database.connections.mysql.password', ''),
        ];

        // Set environment variables for the current process so the child process (Python) inherits them
        foreach ($env as $k => $v) {
            putenv("$k=$v");
        }

        $command = 'python ' . escapeshellarg($scriptPath) . ' 2>&1';
        $output  = shell_exec($command);

        if (empty($output)) {
            // Try python3
            $command = 'python3 ' . escapeshellarg($scriptPath) . ' 2>&1';
            $output  = shell_exec($command);
        }

        $data = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE || isset($data['error'])) {
            $this->error('Analytics script failed: ' . ($data['error'] ?? $output));
            return self::FAILURE;
        }

        Cache::put($cacheKey, $data, $cacheTtl);
        $this->info('Analytics data refreshed and cached successfully!');
        $this->line('Summary: ' . $data['summary']['total_orders'] . ' orders, $' . number_format($data['summary']['total_revenue'], 2) . ' revenue');

        return self::SUCCESS;
    }
}
