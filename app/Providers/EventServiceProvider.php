<?php

namespace App\Providers;

use App\Actions\Badge\BadgeUserVerify;
use App\Actions\Comment\CommentWrittenAction;
use App\Actions\Lesson\LessonWatchedAction;
use App\Actions\User\UserAchievementReceived;
use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        LessonWatched::class => [
            LessonWatchedAction::class,
        ],
        CommentWritten::class => [
            CommentWrittenAction::class,
        ],
        AchievementUnlocked::class => [
            UserAchievementReceived::class,
            BadgeUserVerify::class,
        ],
        BadgeUnlocked::class => []
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        User::class => [UserObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
