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
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });

        Schema::table('layanan_publiks', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'urutan']);
        });

        Schema::table('aplikasi_dinas', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->string('deskripsi', 500)->nullable();
        });

        Schema::table('layanan_publiks', function (Blueprint $table) {
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('urutan')->default(0);
        });

        Schema::table('aplikasi_dinas', function (Blueprint $table) {
            $table->unsignedInteger('urutan')->default(0);
        });
    }
};
