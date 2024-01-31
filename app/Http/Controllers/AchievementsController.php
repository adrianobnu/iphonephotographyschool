<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserAchievementResource;
use App\Models\User;

class AchievementsController extends Controller
{
    public function __invoke(User $user)
    {
        return new UserAchievementResource($user);
    }
}
