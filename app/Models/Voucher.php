<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'kode_voucher',
        'nama_voucher',
        'tipe',
        'nilai',
        'batas_penggunaan',
        'jumlah_terpakai',
        'berlaku_dari',
        'berlaku_sampai',
        'is_active',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
        'berlaku_dari' => 'date',
        'berlaku_sampai' => 'date',
        'is_active' => 'boolean',
    ];
}
