<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix PostgreSQL sequences that get out of sync when data is seeded
     * directly (bypassing the sequence). This causes SQLSTATE[23505] errors.
     */
    public function up(): void
    {
        if (config('database.default') !== 'pgsql') {
            return; // Only needed for PostgreSQL
        }

        $tables = [
            'users', 'categories', 'products', 'orders',
            'order_details', 'media', 'permissions', 'roles',
        ];

        foreach ($tables as $table) {
            if (!DB::getSchemaBuilder()->hasTable($table)) {
                continue;
            }

            try {
                DB::statement("
                    SELECT setval(
                        pg_get_serial_sequence('{$table}', 'id'),
                        COALESCE((SELECT MAX(id) FROM \"{$table}\"), 1)
                    )
                ");
            } catch (\Exception $e) {
                // Sequence may not exist for this table; skip silently
            }
        }
    }

    public function down(): void
    {
        // Cannot reverse a sequence reset
    }
};
