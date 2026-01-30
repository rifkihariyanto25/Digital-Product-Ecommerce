<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->string('kode_voucher')->unique()->after('id');
            $table->string('nama_voucher')->after('kode_voucher');
            $table->enum('tipe', ['persentase', 'nominal'])->default('persentase')->after('nama_voucher');
            $table->decimal('nilai', 10, 2)->default(0)->after('tipe');
            $table->integer('batas_penggunaan')->default(0)->after('nilai');
            $table->integer('jumlah_terpakai')->default(0)->after('batas_penggunaan');
            $table->date('berlaku_dari')->after('jumlah_terpakai');
            $table->date('berlaku_sampai')->after('berlaku_dari');
            $table->boolean('is_active')->default(true)->after('berlaku_sampai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn(['kode_voucher', 'nama_voucher', 'tipe', 'nilai', 'batas_penggunaan', 'jumlah_terpakai', 'berlaku_dari', 'berlaku_sampai', 'is_active']);
        });
    }
};
