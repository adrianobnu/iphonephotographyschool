<?php

namespace Database\Seeders;

use App\Models\Lesson;
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
        $this->call(AchievementSeeder::class);
        $this->call(BadgeSeeder::class);

        Lesson::factory(5)->create();

        User::factory(5)->create();

        User::factory()->create([
            'name' => 'Demo User',
            'is_admin' => true,
            'email' => 'demo@demo.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
