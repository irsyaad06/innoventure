<?php

namespace App\Filament\Resources\CabangLombaResource\Pages;

use App\Filament\Resources\CabangLombaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCabangLomba extends EditRecord
{
    protected static string $resource = CabangLombaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
