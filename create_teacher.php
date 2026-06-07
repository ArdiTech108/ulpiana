<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email', 'profesori@ulpiana.edu')->first();
if (!$user) {
    $user = new User();
    $user->full_name = 'Test Profesor';
    $user->email = 'profesori@ulpiana.edu';
    $user->password_hash = bcrypt('prof123');
    $user->role = 'teacher';
    $user->save();
    echo "Teacher user created successfully!\n";
} else {
    echo "Teacher user already exists.\n";
}
