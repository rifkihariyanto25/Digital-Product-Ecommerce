<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'position',
        'company',
        'avatar',
        'content',
        'rating',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'rating' => 'integer',
    ];

    protected static function booted(): void
    {
        static::updating(function ($testimonial) {
            if ($testimonial->isDirty('avatar') && $testimonial->getOriginal('avatar')) {
                Storage::disk('public')->delete($testimonial->getOriginal('avatar'));
            }
        });

        static::deleting(function ($testimonial) {
            if ($testimonial->avatar) {
                Storage::disk('public')->delete($testimonial->avatar);
            }
        });
    }
}
