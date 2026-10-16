<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'link_url', 'ends_at', 'is_active'];

    protected $casts = [
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}