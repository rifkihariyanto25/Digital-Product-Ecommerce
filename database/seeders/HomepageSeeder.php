<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\MediaCoverage;
use App\Models\Testimonial;
use App\Models\QnaSection;
use App\Models\InformationCard;
use Illuminate\Database\Seeder;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Settings
        Setting::create([
            'nama_toko' => 'Templatenesia',
            'deskripsi_toko' => 'Platform terpercaya untuk membeli produk digital berkualitas. Pusat download dokumen SOP Perusahaan, KPI, dan Form Bisnis siap pakai.',
            'email_toko' => 'info@templatenesia.com',
            'nomor_telepon_toko' => '6285758952957',
            'facebook' => 'https://facebook.com/templatenesia',
            'instagram' => 'https://instagram.com/templatenesia',
            'tiktok' => 'https://tiktok.com/@templatenesia',
            'youtube' => 'https://youtube.com/@templatenesia',
            'nomor_whatsapp_owner' => '6285761853324',
            'payment_gateway' => true,
            'biaya_layanan_midtrans' => 10000,
            'notifikasi_whatsapp' => true,
        ]);

        // Seed Information Cards
        InformationCard::insert([
            [
                'icon' => 'icons/editable.png',
                'title' => '100% Editable',
                'description' => 'File format Ms Word & Excel yang bisa diedit sesuai kebutuhan.',
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'icons/instant.png',
                'title' => 'Instant Download',
                'description' => 'Link download otomatis masuk ke WhatsApp setelah pembayaran.',
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'icons/iso.png',
                'title' => 'Standar ISO',
                'description' => 'Dokumen sesuai ISO 9001:2015 untuk sistem manajemen mutu.',
                'order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'icons/support.png',
                'title' => 'Support Admin',
                'description' => 'Bantuan cepat via WhatsApp jika ada kendala.',
                'order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed Media Coverage (Logo Liputan)
        MediaCoverage::insert([
            [
                'name' => 'Detik',
                'logo' => 'media/detik.png',
                'url' => 'https://detik.com',
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kompas',
                'logo' => 'media/kompas.png',
                'url' => 'https://kompas.com',
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed Testimonials
        Testimonial::insert([
            [
                'name' => 'Agus Santoso',
                'position' => 'CEO',
                'company' => 'PT Maju Jaya',
                'content' => 'Proses pembelian sangat cepat, file langsung terkirim ke WA. Dokumennya rapi banget dan sangat membantu!',
                'rating' => 5,
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'position' => 'HRD Manager',
                'company' => 'PT Berkah',
                'content' => 'Template SOP HRD nya lengkap banget, tinggal edit sesuai kebutuhan. Worth it!',
                'rating' => 5,
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Jaya',
                'position' => 'Owner',
                'company' => 'UMKM Sejahtera',
                'content' => 'Hemat waktu dan biaya daripada bikin dari nol. Admin juga responsif bantu saya.',
                'rating' => 5,
                'order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed FAQs
        QnaSection::insert([
            [
                'question' => 'Bagaimana cara melakukan pembelian?',
                'answer' => 'Pilih produk yang diinginkan, klik tombol beli, lakukan pembayaran, dan link download otomatis dikirim ke WhatsApp/Email Anda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah file bisa diedit?',
                'answer' => 'Ya, 100% bisa diedit. File yang dikirim berformat Microsoft Word (.docx) dan Excel (.xlsx), bukan PDF terkunci.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah ada garansi jika file rusak?',
                'answer' => 'Tentu. Jika link tidak bisa diakses atau file rusak, silakan hubungi admin untuk dikirim ulang secara manual.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Metode pembayaran apa yang tersedia?',
                'answer' => 'Kami menerima pembayaran via Transfer Bank (BCA, Mandiri, BRI, BNI), E-Wallet (GoPay, OVO, Dana), dan QRIS.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
