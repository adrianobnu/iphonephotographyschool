<?php

namespace App\Observers;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * @param User $user
     *
     * @return void
     */
    public function creating(User $user): void
    {
        if (!$user->password) {
            $user->password = Hash::make(Str::random(8));
        }

        if ($badge = Badge::orderBy('achievements_quantity')->first()) {
            $user->{'badge_id'} = $badge->id;
        }
    }
}
