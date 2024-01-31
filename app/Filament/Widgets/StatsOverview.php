<?php

namespace App\Filament\Widgets;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total users', User::count()),
            Stat::make('Total lessons watched', Lesson::count()),
            Stat::make('Total badges', Badge::count()),
            Stat::make('Total achievements', Achievement::count()),
            Stat::make('Total comments written', Comment::count()),
        ];
    }
}
