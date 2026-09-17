<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    use HasFactory;

    protected $table = 'posters';

    protected $fillable = [
        'judul',
        'slug',
        'foto_poster',
        'deskripsi',
        'tanggal_publikasi',
        'aktif',
        'views_count',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'date',
        'aktif' => 'boolean',
        'views_count' => 'integer',
    ];

    public function scopeTerpopuler($query, $limit = 5)
    {
        return $query->where('aktif', true)
            ->orderByDesc('views_count')
            ->orderByDesc('tanggal_publikasi')
            ->take($limit);
    }
}
