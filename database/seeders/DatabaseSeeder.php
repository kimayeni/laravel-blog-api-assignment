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
    \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    \App\Models\Post::truncate();
    \App\Models\User::truncate();

    \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    \App\Models\User::create([
        'name' => 'Test User 1',
        'email' => 'user1@example.com',
        'password' => bcrypt('password123'),
    ]);

    \App\Models\User::create([
        'name' => 'Test User 2',
        'email' => 'user2@example.com',
        'password' => bcrypt('password123'),
    ]);

    $this->call([
        PostSeeder::class,
    ]);
}
}
