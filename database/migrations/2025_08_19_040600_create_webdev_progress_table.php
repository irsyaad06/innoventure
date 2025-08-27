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
        Schema::create('webdev_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('tims')->onDelete('cascade');
            $table->string('email_ketua')->unique();
            $table->string('judul_proyek');
            $table->text('catatan'); // upload file deskripsi singkat (PDF)
            $table->string('link_repository')->nullable(); // GitHub/Drive
            $table->string('link_demo')->nullable(); // YouTube/Drive
            $table->string('link_hosting')->nullable(); // website/hosting
            $table->string('ppt')->nullable(); // PowerPoint presentasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webdev_progress');
    }
};
