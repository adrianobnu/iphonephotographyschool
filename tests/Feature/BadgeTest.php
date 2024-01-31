<?php

use App\Actions\Badge\BadgeUserVerify;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Verify if the users its created with the basic badge', function () {
    $user = User::factory()->create();
    $badge = Badge::orderBy('achievements_quantity')->first();

    expect($user->badge_id)->toBe($badge->id);
});

it('Verify badges for a new users', function () {
    $user = User::factory()->create();
    $firstBadge = Badge::orderBy('achievements_quantity')->first();
    $nextBadge = Badge::orderBy('achievements_quantity')->where('achievements_quantity', '>', $firstBadge->achievements_quantity)->first();

    $response = $this->getJson("/users/{$user->id}/achievements");

    expect($response->status())->toBe(200);
    expect($response->json('current_badge'))->toBe($firstBadge->title);
    expect($response->json('next_badge'))->toBe($nextBadge->title);
    expect($response->json('remaing_to_unlock_next_badge'))->toBe($nextBadge->achievements_quantity - $firstBadge->achievements_quantity);
});

it('Verify if the users has the correct badge based on the total achievements', function () {
    foreach (Badge::all() as $badge) {
        $user = User::factory()->create();

        Achievement::take($badge->achievements_quantity)
            ->get()
            ->each(function ($achievement) use ($user) {
                $user->achievements()->attach($achievement);
            });

        BadgeUserVerify::run($user);

        expect($user->badge_id)->toBe($badge->id);
    }
});
