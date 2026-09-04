<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Pengumuman extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'aktif'])
            ->logOnlyDirty()
            ->useLogName('pengumuman');
    }

    protected $table = 'pengumumen';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengumuman) {
            if (empty($pengumuman->slug)) {
                $pengumuman->slug = Str::slug($pengumuman->title) . '-' . Str::random(5);
            }
        });
    }
}
