<?php

namespace App\Filament\Resources\AbsensiResource\Pages;

use App\Filament\Resources\AbsensiResource;
use App\Filament\Pages\Absensi;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsensis extends ListRecords
{
    protected static string $resource = AbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Ganti default CreateAction dengan Action biasa yang mengarah ke URL custom
            Actions\Action::make('create')
                ->label('Lakukan Absensi') // Ganti label tombol
                ->icon('heroicon-o-qr-code')
                ->url(Absensi::getUrl()), // Arahkan ke URL halaman scanner Anda
        ];
    }
}
