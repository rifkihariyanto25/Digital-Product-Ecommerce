<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformationCard extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'description',
        'link',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
