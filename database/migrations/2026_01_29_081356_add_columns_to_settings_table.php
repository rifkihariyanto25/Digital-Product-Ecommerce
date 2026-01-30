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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('id');
            $table->string('nama_toko')->after('logo');
            $table->text('deskripsi_toko')->nullable()->after('nama_toko');
            $table->string('email_toko')->nullable()->after('deskripsi_toko');
            $table->string('nomor_telepon_toko')->nullable()->after('email_toko');
            $table->string('facebook')->nullable()->after('nomor_telepon_toko');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('tiktok')->nullable()->after('instagram');
            $table->string('youtube')->nullable()->after('tiktok');
            $table->boolean('payment_gateway')->default(false)->after('youtube');
            $table->decimal('biaya_layanan_midtrans', 10, 2)->default(0)->after('payment_gateway');
            $table->boolean('notifikasi_whatsapp')->default(false)->after('biaya_layanan_midtrans');
            $table->string('nomor_whatsapp_owner')->nullable()->after('notifikasi_whatsapp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['logo', 'nama_toko', 'deskripsi_toko', 'email_toko', 'nomor_telepon_toko', 'facebook', 'instagram', 'tiktok', 'youtube', 'payment_gateway', 'biaya_layanan_midtrans', 'notifikasi_whatsapp', 'nomor_whatsapp_owner']);
        });
    }
};
