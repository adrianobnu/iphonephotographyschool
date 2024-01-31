<?php

namespace App\Actions\User;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UserAchievementReceived
{
    use AsAction;

    /**
     * @param User $user
     * @param Achievement $achievement
     *
     * @return void
     */
    public function handle(User $user, Achievement $achievement): void
    {
        $user->achievements()->sync($achievement->id, false);
    }

    /**
     * @param AchievementUnlocked $event
     *
     * @return void
     */
    public function asListener(AchievementUnlocked $event): void
    {
        $this->handle($event->user, $event->achievement);
    }
}
