<?php

namespace App\Filament\Resources\WebdevProgressResource\Pages;

use App\Filament\Resources\WebdevProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebdevProgress extends EditRecord
{
    protected static string $resource = WebdevProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

     protected function getRedirectUrl(): string
    {
        return WebdevProgressResource::getUrl('index');
    }
}
