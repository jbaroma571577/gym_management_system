<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gym.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create test member user
        User::factory()->create([
            'name' => 'Test Member',
            'email' => 'member@gym.com',
            'password' => Hash::make('member123'),
            'role' => 'member',
        ]);
    }
}