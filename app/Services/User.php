<?php

namespace App\Services;

use App\Enums\AchievementType;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User as ModelsUser;
use Illuminate\Support\Collection;

class User
{
    public function __construct(public ModelsUser $user)
    {
    }

    /**
     * @return Collection|null
     */
    public function getUnlockedAchievements(): Collection|null
    {
        return $this->user->achievements->map(fn ($achievement) => $achievement->title);
    }

    /**
     * @return Collection|null
     */
    public function getNextAvailableAchievements(): Collection|null
    {
        $availableAchievementsByType = collect(AchievementType::cases())
            ->pluck('value')
            ->map(function ($achievementType) {
                $currentHighestAchievementInType = $this->user
                    ->achievements()
                    ->where('type', $achievementType)
                    ->orderBy('quantity', 'desc')
                    ->take(1)
                    ->first();

                return Achievement::where('type', $achievementType)
                    ->when($currentHighestAchievementInType, function ($query) use ($currentHighestAchievementInType) {
                        return $query->where('quantity', '>', $currentHighestAchievementInType->quantity);
                    })
                    ->orderBy('quantity', 'asc')
                    ->take(1)
                    ->first();
            })
            ->filter()
            ->map(fn ($achievement) => $achievement->title);

        return $availableAchievementsByType;
    }

    /**
     * @return string|null
     */
    public function getCurrentBadge(): string|null
    {
        return $this->user->badge?->title;
    }

    /**
     * @return string
     */
    public function getNextBadge(): string|null
    {
        $nextBadge = $this->discoveryNextBadge();

        return $nextBadge ? $nextBadge->title : null;
    }

    /**
     * @return int
     */
    public function getRemaingToUnlockNextBadge(): int|null
    {
        $currentBadgeQuantity = $this->user->badge?->achievements_quantity ?? 0;
        $nextBadge = $this->discoveryNextBadge();

        return $nextBadge?->achievements_quantity - $currentBadgeQuantity;
    }

    /**
     * @return Badge|null
     */
    private function discoveryNextBadge(): Badge|null
    {
        return Badge::where('achievements_quantity', '>', $this->user->badge?->achievements_quantity ?? 0)
            ->orderBy('achievements_quantity', 'asc')
            ->take(1)
            ->first();
    }
}
