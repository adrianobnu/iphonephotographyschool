<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = collect([
            [
                'title' => 'Beginner',
                'achievements_quantity' => 1,
            ],
            [
                'title' => 'Intermediate',
                'achievements_quantity' => 4,
            ],
            [
                'title' => 'Advanced',
                'achievements_quantity' => 8,
            ],
            [
                'title' => 'Master',
                'achievements_quantity' => 10,
            ]
        ]);

        $badges->each(fn ($badge) => \App\Models\Badge::updateOrCreate(['title' => $badge['title']], $badge));
    }
}
