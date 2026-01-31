<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaCoverage extends Model
{
    protected $fillable = [
        'logo',
        'name',
        'url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
