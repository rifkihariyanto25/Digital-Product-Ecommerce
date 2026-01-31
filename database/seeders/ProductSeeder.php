<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Programming & Development
            [
                'category_id' => 1,
                'name' => 'Laravel Mastery: Dari Pemula Hingga Pro',
                'description' => 'Pelajari Laravel dari dasar hingga mahir dalam membuat aplikasi web modern. Termasuk REST API, Authentication, dan deployment ke production.',
                'price' => 499000,
                'discount_price' => 299000,
                'is_active' => true,
                'is_popular' => true,
                'testimonials' => json_encode([
                    ['name' => 'Budi Santoso', 'position' => 'Full Stack Developer', 'content' => 'Course terbaik yang pernah saya ikuti! Materi lengkap dan praktis banget untuk langsung diterapkan di project real.', 'rating' => 5],
                    ['name' => 'Rina Wijaya', 'position' => 'Backend Developer', 'content' => 'Instruktur menjelaskan dengan sangat detail. Sekarang saya sudah bisa bikin aplikasi Laravel sendiri!', 'rating' => 5],
                    ['name' => 'Ahmad Fauzi', 'position' => 'Freelance Developer', 'content' => 'Worth it banget! Setelah ikut course ini income freelance saya naik 300%', 'rating' => 5],
                ]),
                'faqs' => json_encode([
                    ['question' => 'Apakah cocok untuk pemula?', 'answer' => 'Sangat cocok! Course ini dimulai dari dasar PHP dan Laravel, sehingga pemula pun bisa mengikuti dengan mudah.'],
                    ['question' => 'Berapa lama durasi course?', 'answer' => 'Total durasi video 25 jam, bisa diselesaikan dalam 4-6 minggu jika belajar 1-2 jam per hari.'],
                    ['question' => 'Apakah dapat sertifikat?', 'answer' => 'Ya, Anda akan mendapat sertifikat digital setelah menyelesaikan semua materi dan project final.'],
                ]),
                'bonuses' => json_encode([
                    ['title' => 'E-Book Laravel Best Practices', 'description' => 'Panduan lengkap coding standard dan best practices Laravel'],
                    ['title' => 'Template Admin Dashboard', 'description' => '5 template siap pakai untuk project Anda'],
                    ['title' => 'Lifetime Updates', 'description' => 'Akses selamanya termasuk update materi terbaru'],
                    ['title' => 'Private Community', 'description' => 'Akses grup Telegram eksklusif untuk diskusi'],
                ]),
            ],
            [
                'category_id' => 1,
                'name' => 'JavaScript Modern: ES6+ untuk Web Developer',
                'description' => 'Kuasai JavaScript modern dengan ES6+, async/await, promises, dan konsep-konsep advanced untuk membangun aplikasi web yang powerful.',
                'price' => 399000,
                'discount_price' => 249000,
                'is_active' => true,
                'is_popular' => true,
                'testimonials' => json_encode([
                    ['name' => 'Dedi Kurniawan', 'position' => 'Frontend Developer', 'content' => 'Penjelasan tentang async/await dan promises sangat mudah dipahami. Recommended!', 'rating' => 5],
                    ['name' => 'Lisa Permata', 'position' => 'Web Developer', 'content' => 'Setelah ikut course ini, saya lebih percaya diri dalam menggunakan JavaScript modern.', 'rating' => 4],
                ]),
                'faqs' => json_encode([
                    ['question' => 'Apakah perlu dasar JavaScript?', 'answer' => 'Ya, disarankan sudah menguasai dasar JavaScript seperti variable, function, dan DOM manipulation.'],
                    ['question' => 'Apakah termasuk framework?', 'answer' => 'Course ini fokus ke JavaScript murni (vanilla JS). Namun ada bonus materi pengenalan React dan Vue.'],
                ]),
                'bonuses' => json_encode([
                    ['title' => 'Cheat Sheet JavaScript', 'description' => 'Ringkasan syntax dan method penting'],
                    ['title' => '50+ Coding Challenges', 'description' => 'Latihan soal untuk mengasah skill'],
                ]),
            ],
            
            // Web Design & UI/UX
            [
                'category_id' => 2,
                'name' => 'UI/UX Design Bootcamp: Figma to Production',
                'description' => 'Belajar desain UI/UX dari nol menggunakan Figma. Dari wireframe, prototyping, hingga handoff ke developer.',
                'price' => 599000,
                'discount_price' => 349000,
                'is_active' => true,
                'is_popular' => true,
                'testimonials' => json_encode([
                    ['name' => 'Siti Nurhaliza', 'position' => 'UI/UX Designer', 'content' => 'Course ini mengubah cara saya mendesain. Sekarang portfolio saya penuh dengan project keren!', 'rating' => 5],
                    ['name' => 'Eko Prasetyo', 'position' => 'Product Designer', 'content' => 'Materi design thinking dan user research sangat membantu dalam pekerjaan saya.', 'rating' => 5],
                ]),
                'faqs' => json_encode([
                    ['question' => 'Apakah perlu skill desain sebelumnya?', 'answer' => 'Tidak perlu! Course ini dimulai dari fundamental design hingga advanced techniques.'],
                    ['question' => 'Software apa yang digunakan?', 'answer' => 'Menggunakan Figma (gratis) sebagai tools utama.'],
                ]),
                'bonuses' => json_encode([
                    ['title' => '100+ UI Components', 'description' => 'Library komponen siap pakai di Figma'],
                    ['title' => 'Design System Template', 'description' => 'Template design system professional'],
                    ['title' => 'Color Palette Generator', 'description' => 'Tools untuk membuat kombinasi warna sempurna'],
                ]),
            ],
            [
                'category_id' => 2,
                'name' => 'Web Design dengan Tailwind CSS',
                'description' => 'Buat website modern dan responsive dengan Tailwind CSS. Pelajari utility-first CSS framework yang sedang trending.',
                'price' => 299000,
                'discount_price' => 179000,
                'is_active' => true,
                'is_popular' => false,
                'testimonials' => json_encode([
                    ['name' => 'Rudi Hartono', 'position' => 'Frontend Developer', 'content' => 'Tailwind CSS membuat saya coding 3x lebih cepat. Course ini worth every penny!', 'rating' => 5],
                ]),
                'faqs' => json_encode([
                    ['question' => 'Apakah perlu tahu CSS?', 'answer' => 'Ya, minimal sudah paham dasar CSS seperti flexbox dan grid.'],
                ]),
                'bonuses' => json_encode([
                    ['title' => '20+ Landing Page Templates', 'description' => 'Template siap pakai dengan Tailwind'],
                ]),
            ],

            // Digital Marketing
            [
                'category_id' => 3,
                'name' => 'Digital Marketing 2026: Complete Strategy',
                'description' => 'Panduan lengkap digital marketing: SEO, SEM, Social Media Marketing, Email Marketing, dan Analytics untuk meningkatkan penjualan online.',
                'price' => 799000,
                'discount_price' => 449000,
                'is_active' => true,
                'is_popular' => true,
                'testimonials' => json_encode([
                    ['name' => 'Dewi Lestari', 'position' => 'Digital Marketer', 'content' => 'Omset toko online saya naik 400% dalam 3 bulan setelah apply strategi dari course ini!', 'rating' => 5],
                    ['name' => 'Hendra Wijaya', 'position' => 'Business Owner', 'content' => 'Materinya sangat actionable dan langsung bisa diterapkan. Hasil terlihat dalam 2 minggu!', 'rating' => 5],
                ]),
                'faqs' => json_encode([
                    ['question' => 'Apakah cocok untuk pemula?', 'answer' => 'Sangat cocok! Dijelaskan dari dasar hingga strategi advanced.'],
                    ['question' => 'Berapa lama melihat hasil?', 'answer' => 'Tergantung implementasi, rata-rata siswa melihat hasil dalam 2-4 minggu.'],
                ]),
                'bonuses' => json_encode([
                    ['title' => 'Content Calendar Template', 'description' => 'Template perencanaan konten 1 tahun'],
                    ['title' => 'Facebook Ads Blueprint', 'description' => 'Panduan lengkap beriklan di Facebook & Instagram'],
                    ['title' => 'SEO Checklist', 'description' => 'Checklist optimasi SEO on-page & off-page'],
                ]),
            ],

            // Business & Entrepreneurship
            [
                'category_id' => 4,
                'name' => 'Membangun Startup dari Nol',
                'description' => 'Panduan praktis membangun startup: validasi ide, product development, fundraising, hingga scaling business.',
                'price' => 999000,
                'discount_price' => 599000,
                'is_active' => true,
                'is_popular' => false,
                'testimonials' => json_encode([
                    ['name' => 'Arief Rahman', 'position' => 'Startup Founder', 'content' => 'Course ini membantu saya mendapat funding seed round $100K!', 'rating' => 5],
                ]),
                'faqs' => json_encode([
                    ['question' => 'Apakah perlu modal besar?', 'answer' => 'Tidak! Course ini mengajarkan cara bootstrap dan mencari investor.'],
                ]),
                'bonuses' => json_encode([
                    ['title' => 'Business Model Canvas', 'description' => 'Template dan panduan lengkap'],
                    ['title' => 'Pitch Deck Template', 'description' => '10 template presentasi untuk investor'],
                ]),
            ],

            // Graphic Design
            [
                'category_id' => 5,
                'name' => 'Adobe Illustrator untuk Logo Design',
                'description' => 'Kuasai Adobe Illustrator dan belajar membuat logo professional untuk klien atau bisnis sendiri.',
                'price' => 449000,
                'discount_price' => 269000,
                'is_active' => true,
                'is_popular' => false,
                'testimonials' => json_encode([
                    ['name' => 'Fitri Handayani', 'position' => 'Graphic Designer', 'content' => 'Sekarang saya bisa charge Rp 2-5 juta per logo design. Thanks to this course!', 'rating' => 5],
                ]),
                'faqs' => json_encode([
                    ['question' => 'Apakah dapat software?', 'answer' => 'Software tidak termasuk, tapi kami ajarkan cara trial/beli dengan harga student.'],
                ]),
                'bonuses' => json_encode([
                    ['title' => '500+ Logo Templates', 'description' => 'Inspirasi dan template logo'],
                ]),
            ],

            // Mobile App Development
            [
                'category_id' => 8,
                'name' => 'Flutter: Build Android & iOS Apps',
                'description' => 'Belajar Flutter untuk membuat aplikasi mobile Android dan iOS dengan satu codebase. Dari basic hingga publish ke Play Store & App Store.',
                'price' => 699000,
                'discount_price' => 399000,
                'is_active' => true,
                'is_popular' => true,
                'testimonials' => json_encode([
                    ['name' => 'Yoga Pratama', 'position' => 'Mobile Developer', 'content' => 'Flutter sangat powerful! Sekarang saya bisa bikin app untuk Android dan iOS sekaligus.', 'rating' => 5],
                ]),
                'faqs' => json_encode([
                    ['question' => 'Apakah perlu Dart?', 'answer' => 'Tidak perlu, course ini mengajarkan Dart dari dasar.'],
                ]),
                'bonuses' => json_encode([
                    ['title' => '10+ App Templates', 'description' => 'Source code aplikasi siap pakai'],
                    ['title' => 'Firebase Integration Guide', 'description' => 'Panduan integrasi backend Firebase'],
                ]),
            ],

            // Data Science & AI
            [
                'category_id' => 7,
                'name' => 'Python untuk Data Science & Machine Learning',
                'description' => 'Pelajari Python, Pandas, NumPy, dan Machine Learning untuk menjadi Data Scientist. Termasuk project portfolio.',
                'price' => 899000,
                'discount_price' => 499000,
                'is_active' => true,
                'is_popular' => false,
                'testimonials' => json_encode([
                    ['name' => 'Kevin Surya', 'position' => 'Data Analyst', 'content' => 'Course ini membuka karir baru saya sebagai Data Scientist dengan salary 2x lipat!', 'rating' => 5],
                ]),
                'faqs' => json_encode([
                    ['question' => 'Apakah perlu background IT?', 'answer' => 'Tidak wajib, tapi lebih baik jika sudah punya logic programming dasar.'],
                ]),
                'bonuses' => json_encode([
                    ['title' => 'Dataset Library', 'description' => '50+ dataset untuk practice'],
                    ['title' => 'Jupyter Notebook Templates', 'description' => 'Template analisis data siap pakai'],
                ]),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
