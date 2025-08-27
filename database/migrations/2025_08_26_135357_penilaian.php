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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();

            // Foreign key to the project submission
            $table->foreignId('webdev_progress_id')
                  ->constrained('webdev_progress')
                  ->onDelete('cascade');

            // Foreign key to the assessment aspect
            $table->foreignId('aspek_penilaian_id')
                  ->constrained('aspek_penilaians')
                  ->onDelete('cascade');
            
            // Foreign key to the judge (assuming a 'users' table)
            $table->foreignId('juri_id')
                  ->constrained('juris')
                  ->onDelete('cascade');

            $table->unsignedInteger('skor');
            $table->timestamps();

            // Ensures a judge can only score an aspect once per project
            $table->unique(['webdev_progress_id', 'aspek_penilaian_id', 'juri_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};