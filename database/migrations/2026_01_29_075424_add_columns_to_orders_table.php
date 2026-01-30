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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->unique()->after('id');
            $table->string('customer_name')->after('order_number');
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('customer_phone')->nullable()->after('customer_email');
            $table->text('customer_address')->nullable()->after('customer_phone');
            $table->decimal('harga_produk', 10, 2)->default(0)->after('customer_address');
            $table->decimal('diskon_produk', 10, 2)->default(0)->after('harga_produk');
            $table->decimal('layanan_midtrans', 10, 2)->default(0)->after('diskon_produk');
            $table->decimal('diskon_voucher', 10, 2)->default(0)->after('layanan_midtrans');
            $table->decimal('total_amount', 10, 2)->default(0)->after('diskon_voucher');
            $table->enum('payment_method', ['manual', 'midtrans'])->default('manual')->after('total_amount');
            $table->enum('status_pesanan', ['pending', 'processing', 'completed', 'cancelled'])->default('pending')->after('payment_method');
            $table->enum('status_pembayaran', ['unpaid', 'paid', 'refunded'])->default('unpaid')->after('status_pesanan');
            $table->text('notes')->nullable()->after('status_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_number', 'customer_name', 'customer_email', 'customer_phone', 'customer_address', 'harga_produk', 'diskon_produk', 'layanan_midtrans', 'diskon_voucher', 'total_amount', 'payment_method', 'status_pesanan', 'status_pembayaran', 'notes']);
        });
    }
};
