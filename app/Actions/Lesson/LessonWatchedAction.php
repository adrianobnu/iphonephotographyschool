<?php

namespace App\Actions\Lesson;

use App\Actions\Achievement\AchievementUserVerify;
use App\Enums\AchievementType;
use App\Events\LessonWatched;
use App\Models\Lesson;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Console\Command;

class LessonWatchedAction
{
    use AsAction;

    /**
     * @var string
     */
    public string $commandSignature = 'lesson:watched';

    /**
     * @param Lesson $lesson
     * @param User $user
     *
     * @return void
     */
    public function handle(Lesson $lesson, User $user): void
    {
        $user->lessons()->attach($lesson, [
            'watched' => true,
        ]);

        $totalWatchedLessonsByTheUser = $user->watched->count();

        AchievementUserVerify::dispatch($user, $totalWatchedLessonsByTheUser, AchievementType::LESSON->value);
    }

    /**
     * @param LessonWatched $event
     *
     * @return void
     */
    public function asListener(LessonWatched $event): void
    {
        $this->handle($event->lesson, $event->user);
    }

    /**
     * @param Command $command
     */
    public function asCommand(Command $command)
    {
        $userId = $command->ask('Give the User ID', 1);

        if (!$user = User::find($userId)) {
            return $command->error('User not found.');
        }

        $this->handle(
            Lesson::inRandomOrder()->first(),
            $user,
        );
    }
}
