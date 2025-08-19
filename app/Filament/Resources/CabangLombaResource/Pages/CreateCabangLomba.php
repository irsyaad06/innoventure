<?php

namespace App\Filament\Resources\CabangLombaResource\Pages;

use App\Filament\Resources\CabangLombaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCabangLomba extends CreateRecord
{
    protected static string $resource = CabangLombaResource::class;


     protected function getRedirectUrl(): string
    {
        return CabangLombaResource::getUrl('index');
    }
}
