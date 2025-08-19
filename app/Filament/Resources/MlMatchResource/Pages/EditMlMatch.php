<?php

namespace App\Filament\Resources\MlMatchResource\Pages;

use App\Filament\Resources\MlMatchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMlMatch extends EditRecord
{
    protected static string $resource = MlMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return MlMatchResource::getUrl('index');
    }
}
