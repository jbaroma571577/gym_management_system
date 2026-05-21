<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gym.com',
            'role' => 'admin',
        ]);

        // Create test member user
        User::factory()->create([
            'name' => 'Test Member',
            'email' => 'member@gym.com',
            'role' => 'member',
        ]);
    }
}
