<?php

namespace App\Actions\Achievement;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class AchievementUserVerify
{
    use AsAction;

    /**
     * Handle the user's achievements based on the total quantity and achievement type.
     *
     * @param User $user The user object
     * @param int $totalQuantity The total quantity of achievements based on type
     * @param string $achievementType The type of achievement
     * @return void
     */
    public function handle(User $user, int $totalQuantity, string $achievementType): void
    {
        Achievement::where('type', $achievementType)
            ->where('quantity', '<=', $totalQuantity)
            ->get()
            ->each(function (Achievement $achievement) use ($user) {
                event(new AchievementUnlocked($achievement, $user));
            });
    }

    /**
     * @param User $user
     * @param int $totalQuantity
     * @param string $achievementType
     *
     * @return void
     */
    public function asJob(User $user, int $totalQuantity, string $achievementType): void
    {
        $this->handle($user, $totalQuantity, $achievementType);
    }
}
