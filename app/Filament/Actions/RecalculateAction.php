<?php

namespace App\Filament\Actions;

use App\Actions\Achievement\AchievementUserRecalculate;
use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Notifications\Notification;

class RecalculateAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'recalculate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Recalculate')
            ->action(function () {
                AchievementUserRecalculate::run();
                Notification::make()
                    ->title('Recalculated successfully!')
                    ->success()
                    ->send();
            })
            ->requiresConfirmation()
            ->icon('heroicon-m-arrow-path')
            ->color('success');
    }
}
