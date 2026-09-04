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
        Schema::create('sarana_prasarana', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('slug', 255)->unique();
            $table->string('kategori', 100);
            $table->string('sub_kategori', 100)->nullable();
            $table->text('alamat_lengkap');
            $table->string('nagari', 100)->nullable();
            $table->string('kecamatan', 100);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('google_maps_url')->nullable();
            $table->text('rute_layanan')->nullable();
            $table->string('jenis_kendaraan', 255)->nullable();
            $table->text('spesifikasi')->nullable();
            $table->text('tarif_retribusi')->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->enum('status_operasional', ['Aktif', 'Dalam Perbaikan', 'Tidak Beroperasi'])->default('Aktif');
            $table->string('pengelola', 255);
            $table->string('kontak_pengelola', 50)->nullable();
            $table->string('foto_utama', 255)->nullable();
            $table->json('galeri_foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sarana_prasarana');
    }
};
