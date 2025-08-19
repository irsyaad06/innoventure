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
        Schema::create('webdev_progresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('tims')->onDelete('cascade');
            $table->boolean('web_app_uploaded')->default(false);
            $table->boolean('ppt_uploaded')->default(false);
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
