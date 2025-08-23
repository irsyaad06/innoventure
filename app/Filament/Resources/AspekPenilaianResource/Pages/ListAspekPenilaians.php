<?php

namespace App\Filament\Resources\AspekPenilaianResource\Pages;

use App\Filament\Resources\AspekPenilaianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAspekPenilaians extends ListRecords
{
    protected static string $resource = AspekPenilaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
