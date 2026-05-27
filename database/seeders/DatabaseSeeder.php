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
        User::updateOrCreate([
            'email' => 'admin@gym.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create test member user
        User::updateOrCreate([
            'email' => 'member@gym.com',
        ], [
            'name' => 'Test Member',
            'password' => Hash::make('member123'),
            'role' => 'member',
        ]);

        User::updateOrCreate([
            'email' => 'trainer1@gym.com',
        ], [
            'name' => 'Trainer One',
            'password' => Hash::make('trainer123'),
            'role' => 'trainer',
            'is_available' => true,
        ]);

        User::updateOrCreate([
            'email' => 'trainer2@gym.com',
        ], [
            'name' => 'Trainer Two',
            'password' => Hash::make('trainer123'),
            'role' => 'trainer',
            'is_available' => false,
        ]);
    }
}