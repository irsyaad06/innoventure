<?php

namespace App\Filament\Resources\MlMatchResource\Pages;

use App\Filament\Resources\MlMatchResource;
use App\Models\MlMatch;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMlMatch extends CreateRecord
{
    protected static string $resource = MlMatchResource::class;
    protected function getRedirectUrl(): string
    {
        return MlMatchResource::getUrl('index');
    }
}
