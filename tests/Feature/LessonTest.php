<?php

use App\Actions\Achievement\AchievementUserVerify;
use App\Enums\AchievementType;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\Lesson;
use App\Models\User;

it('Verify if the user receives the first achievement for lesson', function () {
    $user = User::factory()->create();
    $firstAchievement = Achievement::where('type', AchievementType::LESSON->value)->orderBy('quantity')->first();
    $lesson = Lesson::first();

    event(new LessonWatched($lesson, $user));

    $response = $this->getJson("/users/{$user->id}/achievements");

    expect($response->json('unlocked_achievements'))->toBe([$firstAchievement->title]);
    expect($response->status())->toBe(200);
});

it('Verify if the user receives all achievement for lesson when hit the maxium quantity', function () {
    $user = User::factory()->create();
    $allAchievements = Achievement::where('type', AchievementType::LESSON->value)->orderBy('quantity')->get();
    $lastAchievement = $allAchievements->last();

    foreach (range(1, $lastAchievement->quantity) as $_) {
        $lesson = Lesson::factory()->create();

        event(new LessonWatched($lesson, $user));
    }

    AchievementUserVerify::run($user, $lastAchievement->quantity, AchievementType::LESSON->value);

    $response = $this->getJson("/users/{$user->id}/achievements");

    expect($response->json('unlocked_achievements'))->toBe($allAchievements->pluck('title')->toArray());
});
