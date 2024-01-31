<?php

namespace Database\Seeders;

use App\Enums\AchievementType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = collect([
            [
                'title' => 'First Lesson Watched',
                'quantity' => 1,
                'type' => AchievementType::LESSON->value
            ],
            [
                'title' => '5 Lessons Watched',
                'quantity' => 5,
                'type' => AchievementType::LESSON->value
            ],
            [
                'title' => '10 Lessons Watched',
                'quantity' => 10,
                'type' => AchievementType::LESSON->value
            ],
            [
                'title' => '25 Lessons Watched',
                'quantity' => 25,
                'type' => AchievementType::LESSON->value
            ],
            [
                'title' => '50 Lessons Watched',
                'quantity' => 50,
                'type' => AchievementType::LESSON->value
            ],
            [
                'title' => 'First Comment Written',
                'quantity' => 1,
                'type' => AchievementType::COMMENT->value
            ],
            [
                'title' => '3 Comments Written',
                'quantity' => 3,
                'type' => AchievementType::COMMENT->value
            ],
            [
                'title' => '5 Comments Written',
                'quantity' => 5,
                'type' => AchievementType::COMMENT->value
            ],
            [
                'title' => '10 Comments Written',
                'quantity' => 10,
                'type' => AchievementType::COMMENT->value
            ],
            [
                'title' => '20 Comments Written',
                'quantity' => 20,
                'type' => AchievementType::COMMENT->value
            ],
        ]);

        $achievements->each(fn ($achievement) => \App\Models\Achievement::updateOrCreate(['title' => $achievement['title']], $achievement));
    }
}
