<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'session_id',
        'ip_address',
        'browser',
        'platform',
        'device_type',
        'url',
        'visited_at'
    ];
}
