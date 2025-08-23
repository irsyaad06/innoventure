<?php

namespace App\Filament\Resources\AspekPenilaianResource\Pages;

use App\Filament\Resources\AspekPenilaianResource;
use App\Models\AspekPenilaian;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAspekPenilaian extends CreateRecord
{
    protected static string $resource = AspekPenilaianResource::class;

    protected function getRedirectUrl(): string
    {
        return AspekPenilaianResource::getUrl('index');
    }

}
