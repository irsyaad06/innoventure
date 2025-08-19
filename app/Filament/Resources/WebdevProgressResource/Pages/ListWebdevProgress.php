<?php

namespace App\Filament\Resources\WebdevProgressResource\Pages;

use App\Filament\Resources\WebdevProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebdevProgress extends ListRecords
{
    protected static string $resource = WebdevProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
