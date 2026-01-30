<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
