<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'harga_produk',
        'diskon_produk',
        'layanan_midtrans',
        'diskon_voucher',
        'total_amount',
        'payment_method',
        'status_pesanan',
        'status_pembayaran',
        'notes',
    ];

    protected $casts = [
        'harga_produk' => 'decimal:2',
        'diskon_produk' => 'decimal:2',
        'layanan_midtrans' => 'decimal:2',
        'diskon_voucher' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];
}
