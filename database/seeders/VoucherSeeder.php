<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        Voucher::insert([
            [
                'kode_voucher' => 'PENGGUNABARU',
                'nama_voucher' => 'Potongan khusus pengguna baru',
                'tipe' => 'nominal',
                'nilai' => 50000.00,
                'batas_penggunaan' => 100,
                'jumlah_terpakai' => 12,
                'berlaku_dari' => Carbon::now()->subDays(7),
                'berlaku_sampai' => Carbon::now()->addDays(30),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_voucher' => 'DISKON10',
                'nama_voucher' => 'Potongan Rp 10.000 untuk semua produk',
                'tipe' => 'nominal',
                'nilai' => 10000.00,
                'batas_penggunaan' => 500,
                'jumlah_terpakai' => 87,
                'berlaku_dari' => Carbon::now()->subDays(14),
                'berlaku_sampai' => Carbon::now()->addDays(60),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_voucher' => 'HEMAT25K',
                'nama_voucher' => 'Hemat Rp 25.000 untuk pembelian hari ini',
                'tipe' => 'nominal',
                'nilai' => 25000.00,
                'batas_penggunaan' => 50,
                'jumlah_terpakai' => 23,
                'berlaku_dari' => Carbon::now()->subDays(3),
                'berlaku_sampai' => Carbon::now()->addDays(7),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_voucher' => 'PROMO15',
                'nama_voucher' => 'Diskon 15% maksimal Rp 75.000',
                'tipe' => 'persentase',
                'nilai' => 15.00,
                'batas_penggunaan' => 200,
                'jumlah_terpakai' => 45,
                'berlaku_dari' => Carbon::now()->subDays(10),
                'berlaku_sampai' => Carbon::now()->addDays(20),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('Voucher seeder completed successfully!');
    }
}
