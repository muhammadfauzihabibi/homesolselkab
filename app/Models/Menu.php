<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Menu extends Model
{
    use HasFactory, LogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'aktif'])
            ->logOnlyDirty()
            ->useLogName('menu');
    }
    
    protected $fillable = [
        'nama',
        'slug',
        'parent_id',
        'urutan',
        'aktif',
        'tipe',
        'url'
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class,'parent_id');
    }

    public function page()
    {
        return $this->hasMany(Page::class);
    }
}
