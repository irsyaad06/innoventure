<?php

namespace App\Filament\Resources\WebdevProgressResource\Pages;

use App\Filament\Resources\WebdevProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWebdevProgress extends CreateRecord
{
    protected static string $resource = WebdevProgressResource::class;

     protected function getRedirectUrl(): string
    {
        return WebdevProgressResource::getUrl('index');
    }
}
