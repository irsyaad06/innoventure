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
        Schema::create('daftar_seminars', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->index();
            $table->string('instansi');
            $table->string('email')->unique();
            $table->string('no_hp', 20);
            $table->string('no_undian')->unique();
            $table->string('kode_absen')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_seminars');
    }
};