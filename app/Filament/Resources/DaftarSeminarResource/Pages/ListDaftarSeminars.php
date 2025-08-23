<?php

namespace App\Filament\Resources\DaftarSeminarResource\Pages;

use App\Filament\Resources\DaftarSeminarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDaftarSeminars extends ListRecords
{
    protected static string $resource = DaftarSeminarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
