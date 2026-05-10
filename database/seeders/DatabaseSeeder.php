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
    // Admin කෙනෙකු නිර්මාණය කිරීම
    \App\Models\User::factory()->create([
        'name' => 'Apdmin User',
        'email' => 'admin@example.com',
        'role' => 'admin', // Role එක admin ලෙස
        'password' => bcrypt('admin123'),
    ]);

    // සාමාන්‍ය User කෙනෙකු නිර්මාණය කිරීම
    \App\Models\User::factory()->create([
        'name' => 'Regular User',
        'email' => 'user@example.com',
        'role' => 'user', // Role එක user ලෙස
        'password' => bcrypt('password'),
    ]);
    }
}
