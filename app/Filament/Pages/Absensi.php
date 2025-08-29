<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\DaftarSeminar;
// use App\Models\Absensi;
use Filament\Notifications\Notification;

class Absensi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    protected static string $view = 'filament.pages.absensi';
    protected static ?string $title = 'Absensi Seminar';

    public $kodeAbsen = '';

    // Dipanggil saat form auto-submit atau klik button
    public function submit()
    {
        $this->validate([
            'kodeAbsen' => 'required|string',
        ]);

        $peserta = DaftarSeminar::where('kode_absen', $this->kodeAbsen)->first();

        if (! $peserta) {
            Notification::make()
                ->danger()
                ->title('Kode Absen tidak ditemukan!')
                ->send();
            return;
        }

        // Insert absensi jika belum ada
        $absen = \App\Models\Absensi::firstOrCreate(
            ['daftar_seminar_id' => $peserta->id],
            ['waktu_absen' => now()]
        );

        if ($absen->wasRecentlyCreated) {
            Notification::make()
                ->success()
                ->title("Absensi berhasil untuk {$peserta->nama}")
                ->send();
        } else {
            Notification::make()
                ->warning()
                ->title("Peserta {$peserta->nama} sudah absen sebelumnya")
                ->send();
        }

        $this->reset('kodeAbsen'); // kosongkan input biar siap scan berikutnya
    }
}
