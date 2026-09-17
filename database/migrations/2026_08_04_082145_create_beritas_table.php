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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->nullable()->unique();
            $table->string('image')->nullable();
            $table->string('ringkas', 500);
            $table->string('kategori');
            $table->date('tanggal_terbit');
            $table->longText('konten')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            // Berita disiapkan sebagai draft dulu sebelum tayang publik.
            $table->boolean('terbit')->default(true);
            $table->timestamps();

            $table->index(['terbit', 'tanggal_terbit']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
