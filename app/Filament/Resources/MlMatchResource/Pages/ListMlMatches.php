<?php

namespace App\Filament\Resources\MlMatchResource\Pages;

use App\Filament\Resources\MlMatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMlMatches extends ListRecords
{
    protected static string $resource = MlMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
