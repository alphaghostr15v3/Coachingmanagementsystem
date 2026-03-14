<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Coaching;
use App\Models\User;

$user = User::where('email', 'shubham98rockz@gmail.com')->first();
if ($user) {
    echo "USER_FOUND: " . $user->email . " (Role: " . $user->role . ")\n";
    $coaching = $user->coaching;
    if ($coaching) {
        echo "COACHING_FOUND: " . $coaching->coaching_name . " (ID: " . $coaching->id . ")\n";
    } else {
        echo "COACHING_NOT_FOUND for user's coaching_id: " . $user->coaching_id . "\n";
    }
} else {
    echo "USER_NOT_FOUND\n";
}
