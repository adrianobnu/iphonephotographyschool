<?php

namespace App\Filament\Resources\BadgeResource\Pages;

use App\Filament\Actions\RecalculateAction;
use App\Filament\Resources\BadgeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBadges extends ManageRecords
{
    protected static string $resource = BadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            RecalculateAction::make(),
            Actions\CreateAction::make(),
        ];
    }
}
