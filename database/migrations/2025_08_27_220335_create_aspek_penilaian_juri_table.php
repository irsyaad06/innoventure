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
        Schema::create('aspek_penilaian_juri', function (Blueprint $table) {
            $table->foreignId('juri_id')->constrained()->cascadeOnDelete();
            $table->foreignId('aspek_penilaian_id')->constrained()->cascadeOnDelete();
            $table->primary(['juri_id', 'aspek_penilaian_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspek_penilaian_juri');
    }
};
