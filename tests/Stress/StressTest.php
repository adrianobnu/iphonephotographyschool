<?php

use function Pest\Stressless\stress;

it('has a fast response time with 100 requests during 10 seconds', function () {
    $user = App\Models\User::factory()->create();

    $result = stress("localhost/users/{$user->id}/achievements")->concurrency(100)->for(10)->seconds();

    expect($result->requests()->duration()->med())->toBeLessThan(100);
});
