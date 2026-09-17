<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Berita extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'terbit'])
            ->logOnlyDirty()
            ->useLogName('berita');
    }

    protected $table = 'beritas';

    protected $fillable = [
        'judul',
        'slug',
        'image',
        'ringkas',
        'konten',
        'kategori',
        'kategori_berita_id',
        'tanggal_terbit',
        'terbit',
        'views_count',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'terbit' => 'boolean',
        'views_count' => 'integer',
        'kategori_berita_id' => 'integer',
    ];

    public function kategoriBerita()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_berita_id');
    }

    /**
     * Scope query untuk berita terpopuler (dibaca terbanyak)
     */
    public function scopeTerpopuler($query, $limit = 5)
    {
        return $query->where('terbit', true)
            ->orderByDesc('views_count')
            ->orderByDesc('tanggal_terbit')
            ->take($limit);
    }
}
