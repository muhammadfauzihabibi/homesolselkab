<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'aktif',
    ];

    protected $casts = [
        'aktif'      => 'boolean',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($agenda) {
            if (empty($agenda->slug)) {
                $agenda->slug = Str::slug($agenda->title) . '-' . Str::random(5);
            }
        });

        static::updating(function ($agenda) {
            if (empty($agenda->slug)) {
                $agenda->slug = Str::slug($agenda->title) . '-' . Str::random(5);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get agenda status: 'ongoing' (Sedang Berlangsung), 'upcoming' (Akan Datang), or 'past' (Selesai).
     */
    public function getStatusAttribute(): string
    {
        $today = Carbon::today();
        $start = $this->start_date ? Carbon::parse($this->start_date)->startOfDay() : null;
        $end = $this->end_date ? Carbon::parse($this->end_date)->endOfDay() : ($start ? $start->copy()->endOfDay() : null);

        if (!$start) {
            return 'upcoming';
        }

        if ($today->betweenIncluded($start, $end)) {
            return 'ongoing';
        } elseif ($today->lt($start)) {
            return 'upcoming';
        } else {
            return 'past';
        }
    }

    /**
     * Get agenda status label in Indonesian.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'ongoing'  => 'Sedang Berlangsung',
            'upcoming' => 'Akan Datang',
            'past'     => 'Selesai',
        };
    }
}
