<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AplikasiDinas extends Model
{
    use HasFactory;

    protected $table = 'aplikasi_dinas';

    protected $fillable = [
        'nama',
        'url',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];
}
