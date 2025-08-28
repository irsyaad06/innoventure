<?php

namespace App\Filament\Resources\SayembaraProgressResource\Pages;

use App\Filament\Resources\SayembaraProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSayembaraProgress extends ListRecords
{
    protected static string $resource = SayembaraProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
