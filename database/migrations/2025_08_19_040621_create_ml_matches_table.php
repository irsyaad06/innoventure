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
        Schema::create('ml_matches', function (Blueprint $table) {
            $table->id();
            $table->integer('round');
            $table->foreignId('tim1_id')->constrained('tims')->onDelete('cascade');
            $table->foreignId('tim2_id')->constrained('tims')->onDelete('cascade');
            $table->integer('best_of')->default(1);
            $table->integer('tim1_score')->default(0);
            $table->integer('tim2_score')->default(0);
            $table->foreignId('winner_id')->nullable()->constrained('tims')->nullOnDelete();
            $table->enum('status', ['pending', 'live', 'finished'])->default('pending');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ml_matches');
    }
};
