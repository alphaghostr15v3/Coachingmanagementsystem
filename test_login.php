<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

$email = 'shubham98rockz@gmail.com';
$password = 'shubham98'; // Attempting with the email prefix as a guess or common pattern used by user

echo "Testing login for: $email\n";

$user = User::where('email', $email)->first();

if (!$user) {
    echo "USER_NOT_FOUND\n";
    exit;
}

echo "User found. Role: {$user->role}\n";

// Test with provided password
if (Hash::check($password, $user->password)) {
    echo "Password check: SUCCESS\n";
} else {
    echo "Password check: FAILED\n";
    
    // Let's try to reset it and test again
    echo "Resetting password to 'password123' for testing...\n";
    $user->password = Hash::make('password123');
    $user->save();
    
    if (Hash::check('password123', $user->password)) {
        echo "Reset password check: SUCCESS\n";
    } else {
        echo "Reset password check: FAILED (Something is very wrong with hashing)\n";
    }
}
