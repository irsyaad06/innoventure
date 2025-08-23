<?php

namespace App\Filament\Resources\ExternalResource\Pages;

use App\Filament\Resources\ExternalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExternal extends CreateRecord
{
    protected static string $resource = ExternalResource::class;

     protected function getRedirectUrl(): string
    {
        return ExternalResource::getUrl('index');
    }
}
