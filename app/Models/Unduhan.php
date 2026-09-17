<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Unduhan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_unduhan_id',
        'jenis_unduhan_id',
        'title',
        'judul',
        'slug',
        'tahun',
        'description',
        'deskripsi',
        'url',
        'file_path',
        'file_name',
        'file',
        'google_drive_url',
        'aktif',
        'jumlah_unduhan',
        'tanggal_publikasi',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'jumlah_unduhan' => 'integer',
        'tanggal_publikasi' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Unduhan $unduhan): void {
            if (empty($unduhan->title) && !empty($unduhan->judul)) {
                $unduhan->title = $unduhan->judul;
            }
            if (empty($unduhan->judul) && !empty($unduhan->title)) {
                $unduhan->judul = $unduhan->title;
            }
            if (empty($unduhan->description) && !empty($unduhan->deskripsi)) {
                $unduhan->description = $unduhan->deskripsi;
            }
            if (empty($unduhan->deskripsi) && !empty($unduhan->description)) {
                $unduhan->deskripsi = $unduhan->description;
            }
            if (empty($unduhan->slug)) {
                $targetTitle = !empty($unduhan->judul) ? $unduhan->judul : $unduhan->title;
                $unduhan->slug = Str::slug($targetTitle) . '-' . Str::random(5);
            }

            if (empty($unduhan->tanggal_publikasi)) {
                $unduhan->tanggal_publikasi = now();
            }
        });

        static::updating(function (Unduhan $unduhan): void {
            if (empty($unduhan->title) && !empty($unduhan->judul)) {
                $unduhan->title = $unduhan->judul;
            }
            if (empty($unduhan->judul) && !empty($unduhan->title)) {
                $unduhan->judul = $unduhan->title;
            }
            if (empty($unduhan->description) && !empty($unduhan->deskripsi)) {
                $unduhan->description = $unduhan->deskripsi;
            }
            if (empty($unduhan->deskripsi) && !empty($unduhan->description)) {
                $unduhan->deskripsi = $unduhan->description;
            }
            if (($unduhan->isDirty('judul') || $unduhan->isDirty('title')) && empty($unduhan->slug)) {
                $targetTitle = !empty($unduhan->judul) ? $unduhan->judul : $unduhan->title;
                $unduhan->slug = Str::slug($targetTitle) . '-' . Str::random(5);
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

    public function jenis()
    {
        return $this->belongsTo(JenisUnduhan::class, 'jenis_unduhan_id');
    }

    // Alias untuk consistency
    public function jenisUnduhan()
    {
        return $this->belongsTo(JenisUnduhan::class, 'jenis_unduhan_id');
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->latest();
    }

    public function scopeByKategori($query, $kategoriIdOrSlug)
    {
        if (is_numeric($kategoriIdOrSlug)) {
            return $query->where('kategori_unduhan_id', $kategoriIdOrSlug);
        } else {
            return $query->whereHas('kategoriUnduhan', function($q) use ($kategoriIdOrSlug) {
                $q->where('slug', $kategoriIdOrSlug);
            });
        }
    }

    public function scopeByJenis($query, $jenisIdOrSlug)
    {
        if (is_numeric($jenisIdOrSlug)) {
            return $query->where('jenis_unduhan_id', $jenisIdOrSlug);
        } else {
            return $query->whereHas('jenisUnduhan', function($q) use ($jenisIdOrSlug) {
                $q->where('slug', $jenisIdOrSlug);
            });
        }
    }

    public function scopeByTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }

    // Helpers
    public function incrementDownload()
    {
        $this->increment('jumlah_unduhan');
    }

    public function getDownloadUrl()
    {
        // Prioritas: Google Drive URL > File lokal
        if (!empty($this->google_drive_url)) {
            return $this->google_drive_url;
        }

        if (!empty($this->file)) {
            return asset('storage/' . $this->file);
        }

        return null;
    }

    public function hasGoogleDrive()
    {
        return !empty($this->google_drive_url);
    }

    public function hasLocalFile()
    {
        return !empty($this->file);
    }

    // Google Drive direct download conversion
    public function getDirectDownloadUrl()
    {
        $url = $this->google_drive_url;

        if (empty($url)) {
            return null;
        }

        // Convert Google Drive share link to direct download
        // From: https://drive.google.com/file/d/FILE_ID/view?usp=sharing
        // To: https://drive.google.com/uc?export=download&id=FILE_ID

        // Pattern 1: /file/d/FILE_ID/view atau /file/d/FILE_ID/edit
        if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];
            return "https://drive.google.com/uc?export=download&id={$fileId}";
        }

        // Pattern 2: ?id=FILE_ID (already direct download format)
        if (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];
            return "https://drive.google.com/uc?export=download&id={$fileId}";
        }

        // Pattern 3: drive.google.com/open?id=FILE_ID
        if (preg_match('/\/open\?id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];
            return "https://drive.google.com/uc?export=download&id={$fileId}";
        }

        // Jika tidak match pattern apapun, kembalikan URL asli
        // User bisa copy-paste link langsung ke browser
        return $url;
    }
}
