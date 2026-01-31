<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'logo',
        'nama_toko',
        'deskripsi_toko',
        'email_toko',
        'nomor_telepon_toko',
        'facebook',
        'instagram',
        'tiktok',
        'youtube',
        'payment_gateway',
        'biaya_layanan_midtrans',
        'notifikasi_whatsapp',
        'nomor_whatsapp_owner',
    ];

    protected $casts = [
        'payment_gateway' => 'boolean',
        'notifikasi_whatsapp' => 'boolean',
        'biaya_layanan_midtrans' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::updating(function ($setting) {
            // Jika logo diupdate dan ada logo lama, hapus file lama
            if ($setting->isDirty('logo') && $setting->getOriginal('logo')) {
                Storage::disk('public')->delete($setting->getOriginal('logo'));
            }
        });

        static::deleting(function ($setting) {
            // Hapus logo saat record dihapus
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
        });
    }
}
