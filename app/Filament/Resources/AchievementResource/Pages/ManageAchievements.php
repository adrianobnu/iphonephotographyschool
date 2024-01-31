<?php

namespace App\Filament\Resources\AchievementResource\Pages;

use App\Filament\Actions\RecalculateAction;
use App\Filament\Resources\AchievementResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAchievements extends ManageRecords
{
    protected static string $resource = AchievementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            RecalculateAction::make(),
            Actions\CreateAction::make(),
        ];
    }
}
