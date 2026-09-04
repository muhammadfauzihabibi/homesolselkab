<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayananPublik extends Model
{
    use HasFactory;

    protected $table = 'layanan_publiks';

    protected $fillable = [
        'nama',
        'url',
        'urutan',
        'aktif',
        'deskripsi'
    ];
    protected $casts = [
        'urutan' => 'integer',
        'aktif' => 'boolean',
    ];
}
