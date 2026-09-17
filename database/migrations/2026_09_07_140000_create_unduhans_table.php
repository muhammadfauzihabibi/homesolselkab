<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unduhans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_unduhan_id')->nullable()->constrained('kategori_unduhans')->nullOnDelete();
            $table->foreignId('jenis_unduhan_id')->nullable()->constrained('jenis_unduhans')->nullOnDelete();
            $table->string('title');
            $table->string('judul')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('url', 2048)->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file', 500)->nullable();
            $table->string('google_drive_url', 500)->nullable();
            $table->year('tahun')->nullable();
            $table->integer('jumlah_unduhan')->default(0);
            $table->timestamp('tanggal_publikasi')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unduhans');
    }
};
