<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coaching;
use App\Services\TenantService;
use Illuminate\Support\Facades\DB;

class MigrateTenants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations for all tenant databases';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $coachings = Coaching::all();

        if ($coachings->isEmpty()) {
            $this->info('No coachings found to migrate.');
            return;
        }

        foreach ($coachings as $coaching) {
            $this->info("Migrating database: {$coaching->database_name} ({$coaching->coaching_name})");
            
            try {
                TenantService::switchToTenant($coaching);
                TenantService::runTenantMigrations();
                $this->info("Successfully migrated {$coaching->database_name}");
            } catch (\Exception $e) {
                $this->error("Failed to migrate {$coaching->database_name}: " . $e->getMessage());
            }

            // Switch back to main to be safe before next iteration
            TenantService::switchToMain();
        }

        $this->info('All tenant migrations completed.');
    }
}
