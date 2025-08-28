<?php

namespace App\Filament\Resources\SayembaraProgressResource\Pages;

use App\Filament\Resources\SayembaraProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSayembaraProgress extends EditRecord
{
    protected static string $resource = SayembaraProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return SayembaraProgressResource::getUrl('index');
    }
}
