<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriUnduhan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'icon',
        'urutan',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama);
            }
        });

        static::updating(function ($kategori) {
            if ($kategori->isDirty('nama') && empty($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama);
            }
        });
    }

    // Relationships
    public function jenisUnduhans()
    {
        return $this->hasMany(JenisUnduhan::class)->orderBy('urutan');
    }

    public function unduhans()
    {
        return $this->hasMany(Unduhan::class);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('nama');
    }
}
