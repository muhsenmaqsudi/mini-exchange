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
            'name' => 'First User',
            'email' => 'user1@exchange.com',
            'password' => bcrypt('pass#123'),
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'name' => 'Second User',
            'email' => 'user2@exchange.com',
            'password' => bcrypt('pass#123'),
            'email_verified_at' => now(),
        ]);
    }
}
