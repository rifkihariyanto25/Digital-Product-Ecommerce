<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected static function booted(): void
    {
        static::updating(function ($media) {
            if ($media->isDirty('logo') && $media->getOriginal('logo')) {
                Storage::disk('public')->delete($media->getOriginal('logo'));
            }
        });

        static::deleting(function ($media) {
            if ($media->logo) {
                Storage::disk('public')->delete($media->logo);
            }
        });
    }
}
