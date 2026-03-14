<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

foreach (User::all() as $user) {
    echo "ID: {$user->id} | Email: {$user->email} | Role: {$user->role} | Coaching ID: {$user->coaching_id}\n";
}
