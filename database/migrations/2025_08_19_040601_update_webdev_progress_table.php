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
        Schema::table('webdev_progress', function (Blueprint $table) {
            $table->string('email_ketua')->after('tim_id');
            $table->string('judul_proyek')->after('email_ketua');
            $table->string('deskripsi_pdf')->nullable()->after('judul_proyek');
            $table->string('link_repository')->nullable()->after('deskripsi_pdf');
            $table->string('link_demo')->nullable()->after('link_repository');
            $table->string('link_hosting')->nullable()->after('link_demo');
            $table->string('ppt')->nullable()->after('link_hosting');
            $table->dropColumn('web_app_uploaded');
            $table->dropColumn('ppt_uploaded');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('webdev_progress', function (Blueprint $table) {
            $table->dropColumn([
                'email_ketua',
                'judul_proyek',
                'deskripsi_pdf',
                'link_repository',
                'link_demo',
                'link_hosting',
                'ppt'
            ]);
            $table->boolean('web_app_uploaded')->default(false);
            $table->boolean('ppt_uploaded')->default(false);
        });
    }
};
