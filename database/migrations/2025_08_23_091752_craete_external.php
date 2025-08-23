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
        Schema::create('external', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('logo');
            $table->string('email')->unique(); // Menambahkan unique untuk email
            $table->string('no_hp', 20); // Menentukan panjang maksimum untuk no_hp
            $table->boolean('is_aktif')->default(false); // Mengganti bool dengan boolean
            $table->enum('jenis', ['medpart', 'sponsor'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external'); // Memperbaiki nama tabel
    }
};