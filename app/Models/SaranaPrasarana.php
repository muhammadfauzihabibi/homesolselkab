<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaranaPrasarana extends Model
{
    use HasFactory;

    protected $table = 'sarana_prasarana';

    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'sub_kategori',
        'alamat_lengkap',
        'nagari',
        'kecamatan',
        'latitude',
        'longitude',
        'google_maps_url',
        'rute_layanan',
        'jenis_kendaraan',
        'spesifikasi',
        'tarif_retribusi',
        'kondisi',
        'status_operasional',
        'pengelola',
        'kontak_pengelola',
        'foto_utama',
        'galeri_foto',
    ];

    protected $casts = [
        'galeri_foto' => 'array',
        'latitude'    => 'float',
        'longitude'   => 'float',
    ];
}
