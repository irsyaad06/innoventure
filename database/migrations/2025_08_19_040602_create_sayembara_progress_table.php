<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sayembara_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('tims')->onDelete('cascade');
            $table->string('nim')->unique(); // NIM dibuat unik untuk setiap peserta
            $table->string('kelas');
            $table->string('angkatan');
            $table->text('link_deskripsi_logo'); // Menggunakan text untuk URL panjang
            $table->text('link_file_logo');
            $table->text('link_gdrive_logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sayembara_progress');
    }
};
