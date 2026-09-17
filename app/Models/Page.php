<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Page extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'aktif'])
            ->logOnlyDirty()
            ->useLogName('page');
    }

    protected $fillable = [
        'menu_id',
        'judul',
        'slug',
        'deskripsi',
        'konten',
        'aktif'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
