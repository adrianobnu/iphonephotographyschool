<?php

namespace App\Actions\Badge;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class BadgeUserVerify
{
    use AsAction;

    /**
     * Handle the user's achievements and assign a badge if applicable.
     *
     * @param User $user The user to handle achievements for
     * @return void
     */
    public function handle(User $user): void
    {
        $totalAchievements = $user->achievements->count();

        $badge = Badge::where('achievements_quantity', '<=', $totalAchievements)
            ->orderBy('achievements_quantity', 'desc')
            ->first();

        if ($badge) {
            $user->{'badge_id'} = $badge->id;
            $user->save();

            event(new BadgeUnlocked($badge, $user));
        }
    }

    /**
     * @param AchievementUnlocked $event
     *
     * @return void
     */
    public function asListener(AchievementUnlocked $event): void
    {
        $this->handle($event->user);
    }
}
