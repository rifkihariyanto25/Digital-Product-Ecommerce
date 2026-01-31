<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image',
        'gallery',
        'price',
        'discount_price',
        'is_active',
        'is_popular',
        'testimonials',
        'faqs',
        'bonuses',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'gallery' => 'array',
        'testimonials' => 'array',
        'faqs' => 'array',
        'bonuses' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted(): void
    {
        static::updating(function ($product) {
            // Hapus image lama jika diupdate
            if ($product->isDirty('image') && $product->getOriginal('image')) {
                Storage::disk('public')->delete($product->getOriginal('image'));
            }
            
            // Hapus gallery images lama jika diupdate
            if ($product->isDirty('gallery')) {
                $oldGallery = $product->getOriginal('gallery') ?? [];
                $newGallery = $product->gallery ?? [];
                
                foreach ($oldGallery as $oldImage) {
                    if (!in_array($oldImage, $newGallery)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
        });

        static::deleting(function ($product) {
            // Hapus image saat record dihapus
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Hapus semua gallery images
            if ($product->gallery) {
                foreach ($product->gallery as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        });
    }
}
