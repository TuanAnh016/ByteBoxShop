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

        // Detect current DB connection and pass credentials
        $connection = config('database.default', 'pgsql');
        $dbConfig = config("database.connections.{$connection}", []);

        $env = [
            'DB_CONNECTION' => $connection,
            'DB_HOST'       => $dbConfig['host'] ?? '127.0.0.1',
            'DB_PORT'       => $dbConfig['port'] ?? ($connection === 'mysql' ? '3306' : '5432'),
            'DB_DATABASE'   => $dbConfig['database'] ?? 'bytebox',
            'DB_USERNAME'   => $dbConfig['username'] ?? 'root',
            'DB_PASSWORD'   => $dbConfig['password'] ?? '',
        ];

        // Set environment variables for the child process (Python)
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
