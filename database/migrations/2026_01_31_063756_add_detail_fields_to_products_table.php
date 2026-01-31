<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('gallery')->nullable()->after('image'); // Multiple foto produk
            $table->json('testimonials')->nullable()->after('is_popular'); // Testimoni produk
            $table->json('faqs')->nullable()->after('testimonials'); // FAQ produk
            $table->json('bonuses')->nullable()->after('faqs'); // Bonus produk
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['gallery', 'testimonials', 'faqs', 'bonuses']);
        });
    }
};
