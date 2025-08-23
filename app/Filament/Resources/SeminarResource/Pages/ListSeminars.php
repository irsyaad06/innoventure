<?php

namespace App\Filament\Resources\SeminarResource\Pages;

use App\Filament\Resources\SeminarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeminars extends ListRecords
{
    protected static string $resource = SeminarResource::class;
    public function mount(): void
    {
        $setting = \App\Models\Seminar::first();
        if ($setting) {
            $this->redirect(static::getResource()::getUrl('edit', ['record' => $setting->id]));
            return;
        }
        $this->redirect(static::getResource()::getUrl('create'));
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
