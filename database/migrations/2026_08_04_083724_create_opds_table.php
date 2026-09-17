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
        Schema::create('opds', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('url');
            $table->enum('kategori', ['Dinas', 'Badan', 'Sekretariat', 'Layanan']);
            // Baru tampil publik setelah subdomain diverifikasi aktif oleh
            // Diskominfo — mencegah link mati tayang otomatis.
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->index(['aktif', 'kategori']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opds');
    }
};
