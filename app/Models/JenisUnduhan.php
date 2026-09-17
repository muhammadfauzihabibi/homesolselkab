<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JenisUnduhan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_unduhan_id',
        'nama',
        'slug',
        'deskripsi',
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

        static::creating(function ($jenis) {
            if (empty($jenis->slug)) {
                $jenis->slug = Str::slug($jenis->nama);
            }
        });

        static::updating(function ($jenis) {
            if ($jenis->isDirty('nama') && empty($jenis->slug)) {
                $jenis->slug = Str::slug($jenis->nama);
            }
        });
    }

    // Relationships
    public function kategori()
    {
        return $this->belongsTo(KategoriUnduhan::class, 'kategori_unduhan_id');
    }

    // Alias untuk consistency
    public function kategoriUnduhan()
    {
        return $this->belongsTo(KategoriUnduhan::class, 'kategori_unduhan_id');
    }

    public function unduhans()
    {
        return $this->hasMany(Unduhan::class, 'jenis_unduhan_id');
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
