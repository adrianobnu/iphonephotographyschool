<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Verify if the API endpoints are working for a new user', function () {
    User::factory(5)->create()->each(function ($user) {
        $response = $this->getJson("/users/{$user->id}/achievements");

        expect($response->status())->toBe(200);
    });
});
