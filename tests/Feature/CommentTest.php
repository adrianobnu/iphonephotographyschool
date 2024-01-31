<?php

use App\Actions\Achievement\AchievementUserVerify;
use App\Enums\AchievementType;
use App\Events\CommentWritten;
use App\Models\Achievement;
use App\Models\Comment;
use App\Models\User;

it('Verify if the user receives the first achievement for comment', function () {
    $user = User::factory()->create();
    $firstAchievement = Achievement::where('type', AchievementType::COMMENT->value)->orderBy('quantity')->first();

    $comment = Comment::factory()->create([
        'user_id' => $user->id,
    ]);

    event(new CommentWritten($comment));

    $response = $this->getJson("/users/{$user->id}/achievements");

    expect($response->json('unlocked_achievements'))->toBe([$firstAchievement->title]);
    expect($response->status())->toBe(200);
});

it('Verify if the user receives all achievement for comment when hit the maxium quantity', function () {
    $user = User::factory()->create();
    $allAchievements = Achievement::where('type', AchievementType::COMMENT->value)->orderBy('quantity')->get();
    $lastAchievement = $allAchievements->last();

    foreach (range(1, $lastAchievement->quantity) as $_) {
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        event(new CommentWritten($comment));
    }

    AchievementUserVerify::run($user, $lastAchievement->quantity, AchievementType::COMMENT->value);

    $response = $this->getJson("/users/{$user->id}/achievements");

    expect($response->json('unlocked_achievements'))->toBe($allAchievements->pluck('title')->toArray());
});
