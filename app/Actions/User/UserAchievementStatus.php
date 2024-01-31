<?php

namespace App\Actions\User;

use App\Models\User;
use App\Services\User as ServicesUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;

class UserAchievementStatus
{
    use AsAction;

    /**
     * @param User $user
     *
     * @return void
     */
    public function handle(User $user)
    {
        $service = new ServicesUser($user);

        return [
            'unlocked_achievements' => $service->getUnlockedAchievements(),
            'next_available_achievements' => $service->getNextAvailableAchievements(),
            'current_badge' => $service->getCurrentBadge(),
            'next_badge' => $service->getNextBadge(),
            'remaing_to_unlock_next_badge' => $service->getRemaingToUnlockNextBadge()
        ];
    }

    /**
     * @param User $user
     *
     * @return [type]
     */
    public function asController(User $user): JsonResponse
    {
        $response = $this->handle($user);

        return response()->json($response);
    }

    /**
     * @param Router $router
     *
     * @return void
     */
    public static function routes(Router $router): void
    {
        $router->get('/users/{user}/achievements', static::class)->name('users.achievements');
    }
}
