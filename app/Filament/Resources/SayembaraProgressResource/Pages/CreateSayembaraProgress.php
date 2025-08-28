<?php

namespace App\Filament\Resources\SayembaraProgressResource\Pages;

use App\Filament\Resources\SayembaraProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSayembaraProgress extends CreateRecord
{
    protected static string $resource = SayembaraProgressResource::class;
    protected function getRedirectUrl(): string
    {
        return SayembaraProgressResource::getUrl('index');
    }
}
