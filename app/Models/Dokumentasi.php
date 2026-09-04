<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Dokumentasi extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'tipe'])
            ->logOnlyDirty()
            ->useLogName('dokumentasi');
    }

    protected $fillable = [
        'judul',
        'tanggal',
        'tipe',
        'file_path',
        'url',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function getYoutubeEmbedAttribute()
    {
        if (!$this->url) {
            return null;
        }

        parse_str(parse_url($this->url, PHP_URL_QUERY), $params);

        return isset($params['v'])
            ? 'https://www.youtube.com/embed/'.$params['v']
            : $this->url;
    }
}
