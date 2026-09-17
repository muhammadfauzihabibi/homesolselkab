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
        if (Schema::hasTable('pages') && Schema::hasColumn('pages', 'thumbnail')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('thumbnail');
            });
        }

        if (Schema::hasTable('pengumumen') && Schema::hasColumn('pengumumen', 'thumbnail')) {
            Schema::table('pengumumen', function (Blueprint $table) {
                $table->dropColumn('thumbnail');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pages') && !Schema::hasColumn('pages', 'thumbnail')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->string('thumbnail')->nullable()->after('deskripsi');
            });
        }

        if (Schema::hasTable('pengumumen') && !Schema::hasColumn('pengumumen', 'thumbnail')) {
            Schema::table('pengumumen', function (Blueprint $table) {
                $table->string('thumbnail')->nullable()->after('content');
            });
        }
    }
};
