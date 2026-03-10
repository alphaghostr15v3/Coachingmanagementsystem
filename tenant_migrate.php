<?php

define('LARAVEL_START', microtime(true));
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Coaching;
use App\Services\TenantService;
use Illuminate\Support\Facades\Artisan;

$coachings = Coaching::all();
echo "Found " . count($coachings) . " coaching tenant(s)\n";

foreach ($coachings as $coaching) {
    echo "\n--- Migrating: {$coaching->coaching_name} ({$coaching->database_name}) ---\n";
    TenantService::switchToTenant($coaching);
    Artisan::call('migrate', [
        '--database' => 'tenant',
        '--path'     => 'database/migrations/tenant',
        '--force'    => true,
    ]);
    echo Artisan::output();
}

echo "\nAll tenant migrations complete!\n";
