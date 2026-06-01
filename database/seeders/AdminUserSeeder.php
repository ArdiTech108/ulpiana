<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ulpiana.edu'],
            [
                'full_name' => 'Admin Ulpiana',
                'password_hash' => password_hash('12345', PASSWORD_BCRYPT),
                'role' => 'admin',
            ]
        );
    }
}
