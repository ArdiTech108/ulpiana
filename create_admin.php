<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email', 'admin@ulpiana.edu')->first();
if (!$user) {
    $user = new User();
    $user->full_name = 'Admin';
    $user->email = 'admin@ulpiana.edu';
    $user->password_hash = bcrypt('admin123'); // Fixed column name
    $user->role = 'admin';
    $user->save();
    echo "Admin user created successfully!\n";
} else {
    echo "Admin user already exists.\n";
}
