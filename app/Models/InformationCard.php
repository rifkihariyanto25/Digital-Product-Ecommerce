<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected static function booted(): void
    {
        static::updating(function ($card) {
            if ($card->isDirty('icon') && $card->getOriginal('icon')) {
                Storage::disk('public')->delete($card->getOriginal('icon'));
            }
        });

        static::deleting(function ($card) {
            if ($card->icon) {
                Storage::disk('public')->delete($card->icon);
            }
        });
    }
}
