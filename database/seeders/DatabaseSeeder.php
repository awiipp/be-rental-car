<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'admin_24',
            'no_ktp' => '3566755467019172',
            'name' => 'admin',
            'date_of_birth' => '2000-12-12',
            'email' => 'admin24@email.com',
            'password' => bcrypt('admin_24'),
            'phone' => '1234567890',
            'description' => 'this is admin account.',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'username' => 'user_24',
            'no_ktp' => '3566755467019173',
            'name' => 'user',
            'date_of_birth' => '2000-12-12',
            'email' => 'user24@email.com',
            'password' => bcrypt('user_24'),
            'phone' => '1234567890',
            'description' => 'this is user account.',
            'role' => 'user',
        ]);
    }
}
