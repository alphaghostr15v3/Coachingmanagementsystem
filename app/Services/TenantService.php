<?php

namespace App\Services;

use App\Models\Coaching;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantService
{
    /**
     * Switch the active tenant connection to the specified coaching.
     */
    public static function switchToTenant(Coaching $coaching)
    {
        Config::set('database.connections.tenant.database', $coaching->database_name);
        DB::purge('tenant');
        DB::reconnect('tenant');
    }

    /**
     * Set default connection.
     */
    public static function switchToMain()
    {
        DB::setDefaultConnection('mysql');
    }

    /**
     * Create database and run migrations for a new tenant.
     */
    public static function createTenantDatabase(Coaching $coaching)
    {
        // Generate the CREATE DATABASE statement
        DB::statement("CREATE DATABASE `{$coaching->database_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        // Switch to the newly created database
        self::switchToTenant($coaching);

        // Run migrations
        self::runTenantMigrations();
    }

    /**
     * Run tenant migrations on the current active connection.
     */
    public static function runTenantMigrations()
    {
        // Explicitly set the default connection to 'tenant' before running migrations
        // This ensures Schema::create() in migrations targets the correct DB
        $originalConnection = config('database.default');
        config(['database.default' => 'tenant']);

        try {
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => 'database/migrations/tenant',
                '--force' => true,
            ]);
        } finally {
            // Restore the original connection
            config(['database.default' => $originalConnection]);
        }
    }

    /**
     * Drop the tenant database when the account is deleted.
     */
    public static function dropTenantDatabase(Coaching $coaching)
    {
        DB::statement("DROP DATABASE IF EXISTS `{$coaching->database_name}`");
    }
}
