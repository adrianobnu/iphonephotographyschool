<?php

namespace App\Actions\Achievement;

use App\Enums\AchievementType;
use App\Models\User;
use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;

class AchievementUserRecalculate
{
    use AsAction;

    /**
     * @var string
     */
    public string $commandSignature = 'achievement:recalculate';

    public function handle(): void
    {
        $types = collect(AchievementType::cases())->pluck('value');

        User::all()->each(function (User $user) use ($types) {
            $types->each(function (string $type) use ($user) {
                $totalPerType = $user->achievements()->where('type', $type)->count();

                AchievementUserVerify::run($user, $totalPerType, $type);
            });
        });
    }

    public function asJob(): void
    {
        $this->handle();
    }

    public function asCommand(Command $command)
    {
        $this->handle();
    }
}
