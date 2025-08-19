<?php

namespace App\Filament\Resources\CabangLombaResource\Pages;

use App\Filament\Resources\CabangLombaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCabangLombas extends ListRecords
{
    protected static string $resource = CabangLombaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
