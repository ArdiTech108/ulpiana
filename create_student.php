<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email', 'nxenesi@ulpiana.edu')->first();
if (!$user) {
    $user = new User();
    $user->full_name = 'Test Nxenesi';
    $user->email = 'nxenesi@ulpiana.edu';
    $user->password_hash = bcrypt('nxenesi123');
    $user->role = 'student';
    $user->save();
    echo "Student user created successfully!\n";
} else {
    echo "Student user already exists.\n";
}
