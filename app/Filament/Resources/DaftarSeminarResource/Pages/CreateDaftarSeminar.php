<?php

namespace App\Filament\Resources\DaftarSeminarResource\Pages;

use App\Filament\Resources\DaftarSeminarResource;
use App\Models\DaftarSeminar;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDaftarSeminar extends CreateRecord
{
    protected static string $resource = DaftarSeminarResource::class;

      protected function getRedirectUrl(): string
    {
        return DaftarSeminarResource::getUrl('index');
    }
}
