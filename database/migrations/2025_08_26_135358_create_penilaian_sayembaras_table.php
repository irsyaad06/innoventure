<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel baru 'penilaian_sayembara'.
        // Strukturnya sengaja dibuat sama persis dengan tabel 'penilaians' untuk webdev
        // agar logikanya konsisten.
        Schema::create('penilaian_sayembara', function (Blueprint $table) {
            $table->id();

            // Ini adalah "ID yang berbeda" yang Anda maksud.
            // Kolom ini menghubungkan ke progress sayembara, sama seperti 'webdev_progress_id'
            // di tabel penilaian webdev.
            $table->foreignId('sayembara_progress_id')
                ->constrained('sayembara_progress')
                ->onDelete('cascade');

            // Kolom ini sama persis dengan yang ada di penilaian webdev.
            $table->foreignId('aspek_penilaian_id')
                ->constrained('aspek_penilaians')
                ->onDelete('cascade');

            // Kolom ini juga sama persis.
            $table->foreignId('juri_id')
                ->constrained('juris') // Menambahkan nama tabel 'juris' untuk kejelasan
                ->onDelete('cascade');

            // Kolom skor, sama persis.
            $table->unsignedInteger('skor');
            $table->timestamps();


            $table->unique(
                ['sayembara_progress_id', 'aspek_penilaian_id', 'juri_id'],
                'sayembara_unique_score_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_sayembara');
    }
};
