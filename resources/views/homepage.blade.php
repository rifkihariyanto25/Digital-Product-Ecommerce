@extends('layouts.app')

@section('title', 'Templatenesia - Official Store')

@push('styles')
<style>
    body { background-color: #F5F5F7; color: #1D1D1F; -webkit-font-smoothing: antialiased; }
    
    /* Custom Scrollbar Hide */
    .hide-scroll::-webkit-scrollbar { display: none; }
    .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

    /* Glass Header */
    .glass-header {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    /* Animation */
    @keyframes scroll-left {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-scroll {
        display: flex;
        width: max-content;
        animation: scroll-left 40s linear infinite;
    }
    .animate-scroll:hover { animation-play-state: paused; }

    /* Transition for List */
    .list-enter-active, .list-leave-active { transition: all 0.5s ease; }
    .list-enter-from, .list-leave-to { opacity: 0; transform: translateY(20px); }
</style>
@endpush

@section('content')
<div id="app" class="pb-10">
    
    <header class="fixed top-0 w-full z-50 glass-header transition-all duration-300">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3 cursor-pointer" @click="resetSearch">
                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjRzyTdfjkBugSP3Ew_vmkaeMQKl0XnZVR83kFV0LtKJXC4gVF_WTGPS57iCampIjdlGU09l_Ct0hw_2Tx51GiHj5uWr6fTYqzJirf8qpAKhwW0AsM-pYcam74_l25KpFvShEYQdkJ-UnuJQsuiP7qa7Ek85k0MWaF0X0pHGmJZ2imL8IQK9ip5M9s2sW0/s16000/Templatenesia%20Logo.jpg" 
                     class="w-10 h-10 rounded-lg object-cover shadow-sm" alt="Templatenesia Logo">
                <div>
                    <h1 class="font-heading font-extrabold text-xl text-slate-900 leading-none">Template<span class="text-iosPurple">nesia</span>.</h1>
                </div>
            </div>

            <a :href="whatsappLink" target="_blank" class="flex items-center gap-2 bg-slate-900 hover:bg-iosBlue text-white px-5 py-2.5 rounded-full text-sm font-semibold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:scale-95">
                <i class="ri-whatsapp-line text-lg"></i>
                <span class="hidden sm:inline">Hubungi Admin</span>
            </a>
        </div>
    </header>

    <main class="w-full max-w-screen-xl mx-auto px-4 sm:px-6 pt-32 space-y-24">

        <section class="text-center space-y-8">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full text-iosPurple text-xs font-bold uppercase tracking-wider shadow-sm border border-slate-100">
                <i class="ri-verified-badge-fill text-lg"></i> Official Store
            </div>
            
            <h2 class="font-heading text-4xl md:text-6xl font-extrabold text-slate-900 leading-tight">
                Profesionalisme Bisnis <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-iosBlue to-iosPurple">Dimulai Dari Sini.</span>
            </h2>
            
            <p class="text-slate-500 text-lg max-w-2xl mx-auto leading-relaxed">
                Pusat download dokumen SOP Perusahaan, KPI, dan Form Bisnis siap pakai (Editable). Hemat waktu, tingkatkan efisiensi operasional.
            </p>

            <div class="relative max-w-2xl mx-auto mt-8 group">
                <div class="absolute inset-0 bg-purple-400 rounded-full blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-white rounded-full p-2 pl-6 flex items-center shadow-soft border border-white/50 transition-all focus-within:ring-4 focus-within:ring-purple-100">
                    <i class="ri-search-2-line text-2xl text-slate-400 mr-2"></i>
                    
                    <input v-model="searchQuery" type="text" class="w-full py-3 bg-transparent outline-none text-lg text-slate-800 placeholder-slate-400 font-medium" placeholder="Cari SOP (Ketik untuk filter)...">
                    
                    <button class="bg-slate-900 hover:bg-iosPurple text-white px-8 py-3 rounded-full font-bold transition-all shadow-lg active:scale-95">
                        Cari
                    </button>
                </div>
                <div v-if="searchQuery" class="mt-2 text-sm text-slate-400">
                    Menampilkan hasil untuk: <span class="font-bold text-slate-900">"@{{ searchQuery }}"</span>
                </div>
            </div>
        </section>

        <section v-if="filteredPopular.length > 0">
            <div class="flex items-center gap-2 mb-8 justify-center md:justify-start">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-500 text-xl">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <h3 class="font-heading text-2xl font-bold text-slate-900">Paling Laris</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div v-for="(prod, i) in filteredPopular" :key="prod.name" class="group bg-white rounded-[2rem] p-4 shadow-soft hover:shadow-lg border border-transparent hover:border-blue-100 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="relative aspect-square rounded-[1.5rem] overflow-hidden mb-4 bg-gray-100">
                        <img :src="prod.image" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="Cover">
                        <div class="absolute top-3 right-3 bg-white/80 backdrop-blur-md text-slate-900 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1 shadow-sm">
                            <i class="fa-solid fa-star text-yellow-400"></i> @{{ prod.rating }}
                        </div>
                    </div>
                    <h4 class="font-bold text-slate-800 text-lg leading-snug mb-1 line-clamp-2 group-hover:text-iosBlue">@{{ prod.name }}</h4>
                    <p class="text-xs text-gray-400 mb-4">@{{ prod.sold }} Terjual</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-gray-400 line-through">Rp @{{ formatPrice(prod.oldPrice) }}</div>
                            <div class="text-lg font-bold text-iosBlue">Rp @{{ formatPrice(prod.price) }}</div>
                        </div>
                        <button class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center shadow-md hover:bg-iosBlue transition-colors">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section v-show="!searchQuery" class="bg-slate-900 rounded-[2.5rem] p-8 md:p-14 text-white relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 w-96 h-96 bg-purple-600 opacity-20 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="relative z-10">
                <h3 class="font-heading text-2xl font-bold mb-12 text-center">Cara Kerja Sederhana</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                    <div class="hidden md:block absolute top-6 left-1/6 right-1/6 h-0.5 bg-gray-700 -z-10"></div>
                    <div class="text-center relative">
                        <div class="w-16 h-16 mx-auto bg-gray-800 rounded-2xl border border-slate-600 flex items-center justify-center text-iosBlue text-2xl font-bold mb-4 shadow-lg z-10"><i class="fa-solid fa-cart-shopping"></i></div>
                        <h5 class="font-bold text-lg mb-2">1. Pilih & Beli</h5>
                        <p class="text-sm text-gray-400">Pilih template sesuai kebutuhan.</p>
                    </div>
                    <div class="text-center relative">
                        <div class="w-16 h-16 mx-auto bg-gray-800 rounded-2xl border border-slate-600 flex items-center justify-center text-iosBlue text-2xl font-bold mb-4 shadow-lg z-10"><i class="fa-solid fa-bolt"></i></div>
                        <h5 class="font-bold text-lg mb-2">2. Download Instan</h5>
                        <p class="text-sm text-gray-400">Link file otomatis terkirim.</p>
                    </div>
                    <div class="text-center relative">
                        <div class="w-16 h-16 mx-auto bg-gray-800 rounded-2xl border border-slate-600 flex items-center justify-center text-iosBlue text-2xl font-bold mb-4 shadow-lg z-10"><i class="fa-solid fa-pen-to-square"></i></div>
                        <h5 class="font-bold text-lg mb-2">3. Edit & Pakai</h5>
                        <p class="text-sm text-gray-400">File Word/Excel 100% Editable.</p>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="filteredNew.length > 0">
            <div class="flex items-center gap-2 mb-6">
                <i class="fa-solid fa-sparkles text-yellow-500 text-xl"></i>
                <h3 class="font-heading text-2xl font-bold text-slate-900">Produk Terbaru</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <div v-for="(prod, i) in filteredNew" :key="prod.name" class="bg-white rounded-[2rem] p-3 shadow-soft border border-transparent hover:border-blue-100 transition-all cursor-pointer group">
                    <div class="relative aspect-square rounded-[1.5rem] overflow-hidden mb-3 bg-gray-100">
                        <div class="absolute top-2 left-2 bg-iosBlue text-white text-[10px] font-bold px-2 py-1 rounded-md z-10">NEW</div>
                        <img :src="prod.image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="px-1">
                        <h4 class="font-bold text-slate-800 text-sm md:text-base leading-snug mb-2 line-clamp-2 h-10">@{{ prod.name }}</h4>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-iosBlue">Rp @{{ formatPrice(prod.price) }}</span>
                            <button class="w-8 h-8 rounded-full bg-blue-50 text-iosBlue hover:bg-iosBlue hover:text-white flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-plus text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="filteredPopular.length === 0 && filteredNew.length === 0" class="text-center py-20">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 text-3xl">
                <i class="ri-emotion-unhappy-line"></i>
            </div>
            <h3 class="font-bold text-xl text-slate-900">Produk tidak ditemukan</h3>
            <p class="text-slate-500">Coba gunakan kata kunci lain seperti "SOP", "KPI", atau "Keuangan".</p>
            <button @click="resetSearch" class="mt-4 text-iosBlue font-bold hover:underline">Lihat Semua Produk</button>
        </section>

        <section v-show="!searchQuery" class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-soft">
            <h3 class="font-heading text-2xl font-bold text-center mb-10 text-slate-900">Standard Layanan Kami</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div v-for="(ben, idx) in benefits" :key="idx" class="text-center group">
                    <div class="w-16 h-16 mx-auto bg-blue-50 rounded-2xl flex items-center justify-center text-iosBlue text-3xl mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i :class="ben.icon"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 mb-1">@{{ ben.title }}</h4>
                    <p class="text-xs text-slate-500">@{{ ben.desc }}</p>
                </div>
            </div>
        </section>

        <section v-show="!searchQuery">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 md:p-14 text-white relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-600 rounded-full blur-[120px] opacity-20 pointer-events-none"></div>

                <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <div class="inline-block px-3 py-1 bg-white/10 rounded-lg text-xs font-bold text-blue-300 uppercase tracking-widest">Why Choose Us</div>
                        <h3 class="text-3xl md:text-4xl font-bold leading-tight">Kami Menjual Kualitas <br> & Standard ISO.</h3>
                        <p class="text-slate-400 leading-relaxed">
                            Dokumen kami disusun oleh konsultan berpengalaman, bukan sekadar copy-paste dari internet. Struktur sesuai klausul ISO 9001:2015 yang memudahkan proses audit.
                        </p>
                        <ul class="space-y-4 pt-4">
                            <li class="flex items-center gap-4"><i class="ri-checkbox-circle-fill text-blue-500 text-xl"></i><span class="font-medium text-slate-200">Garansi File Bisa Diedit (Word/Excel)</span></li>
                            <li class="flex items-center gap-4"><i class="ri-checkbox-circle-fill text-blue-500 text-xl"></i><span class="font-medium text-slate-200">Gratis Konsultasi via WhatsApp</span></li>
                            <li class="flex items-center gap-4"><i class="ri-checkbox-circle-fill text-blue-500 text-xl"></i><span class="font-medium text-slate-200">Update Seumur Hidup (Lifetime)</span></li>
                        </ul>
                    </div>
                    
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 transform md:rotate-2 hover:rotate-0 transition-all duration-500">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                            <div class="flex gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div><div class="w-3 h-3 rounded-full bg-yellow-500"></div><div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <span class="text-xs text-slate-400 font-mono">Templatenesia.docx</span>
                        </div>
                        <div class="space-y-3 opacity-50">
                            <div class="h-3 bg-slate-300 rounded w-3/4"></div>
                            <div class="h-3 bg-slate-300 rounded w-full"></div>
                            <div class="h-3 bg-slate-300 rounded w-5/6"></div>
                            <div class="h-20 bg-blue-500/20 rounded border border-blue-500/30 flex items-center justify-center mt-4">
                                <i class="ri-file-text-line text-3xl text-blue-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="overflow-hidden py-10" v-show="!searchQuery">
            <div class="text-center mb-8">
                <span class="text-sm font-bold text-slate-400 uppercase tracking-widest">Telah Diliput Oleh</span>
            </div>
            <div class="relative w-full mask-image-linear">
                <div class="animate-scroll flex items-center gap-12">
                    <img v-for="n in 20" :src="mediaLogos[(n-1) % mediaLogos.length]" class="h-8 md:h-10 w-auto transition-transform hover:scale-110 cursor-pointer">
                </div>
            </div>
        </section>

        <section v-show="!searchQuery">
            <div class="text-center mb-10">
                <h3 class="font-heading text-2xl font-bold text-slate-900">Apa Kata Mereka?</h3>
            </div>
            <div class="relative w-full overflow-hidden mask-image-linear">
                <div class="animate-scroll flex gap-6 pb-10">
                    <div v-for="(testi, i) in [...testimonials, ...testimonials]" :key="i" class="min-w-[300px] md:min-w-[350px] bg-white border border-slate-100 p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-iosBlue to-cyan-400 flex items-center justify-center text-white font-bold text-sm">@{{ getInitials(testi.name) }}</div>
                            <div><h4 class="font-bold text-slate-900 text-sm">@{{ testi.name }}</h4><div class="text-yellow-400 text-xs"><i class="fa-solid fa-star" v-for="s in 5"></i></div></div>
                        </div>
                        <p class="text-slate-500 text-sm italic leading-relaxed">"@{{ testi.text }}"</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-3xl mx-auto" v-show="!searchQuery">
            <div class="text-center mb-10">
                <h3 class="font-heading text-2xl font-bold text-slate-900">Pertanyaan Umum</h3>
            </div>
            <div class="space-y-4">
                <div v-for="(faq, index) in faqs" :key="index" class="bg-white rounded-2xl border border-slate-100 overflow-hidden transition-all duration-300" :class="{'shadow-lg border-blue-100': activeFaq === index, 'shadow-sm': activeFaq !== index}">
                    <button @click="toggleFaq(index)" class="w-full flex items-center justify-between p-5 text-left font-semibold text-slate-800 hover:bg-gray-50 transition-colors">
                        <span>@{{ faq.q }}</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-300 text-iosBlue" :class="{'rotate-180': activeFaq === index}"></i>
                    </button>
                    <div v-show="activeFaq === index" class="p-5 pt-0 text-sm text-slate-500 leading-relaxed border-t border-slate-50 border-dashed"><div class="mt-3">@{{ faq.a }}</div></div>
                </div>
            </div>
        </section>

        <section class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-[2.5rem] p-8 md:p-12 text-center relative overflow-hidden shadow-2xl transition-all hover:scale-[1.005] duration-500">
            <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
            <div class="relative z-10 flex flex-col items-center max-w-2xl mx-auto">
                <div class="w-24 h-24 rounded-full border-4 border-slate-700 overflow-hidden mb-6 shadow-glow bg-slate-800">
                    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjRzyTdfjkBugSP3Ew_vmkaeMQKl0XnZVR83kFV0LtKJXC4gVF_WTGPS57iCampIjdlGU09l_Ct0hw_2Tx51GiHj5uWr6fTYqzJirf8qpAKhwW0AsM-pYcam74_l25KpFvShEYQdkJ-UnuJQsuiP7qa7Ek85k0MWaF0X0pHGmJZ2imL8IQK9ip5M9s2sW0/s16000/Templatenesia%20Logo.jpg" class="w-full h-full object-cover" alt="Profile">
                </div>
                <h2 class="font-heading text-2xl md:text-3xl font-bold text-white mb-3 tracking-tight">PT. Templatenesia Digital Solutions</h2>
                <p class="text-slate-400 mb-10 text-sm leading-relaxed">Mitra terpercaya transformasi sistem manajemen perusahaan Anda. Konsultasi mudah, respon cepat, dan solusi tepat guna.</p>
                <div class="grid grid-cols-4 md:grid-cols-8 gap-4 w-full justify-items-center">
                    <a v-for="(soc, idx) in socials" :key="idx" :href="soc.link" class="flex flex-col items-center gap-2 group cursor-pointer w-full">
                        <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white text-lg group-hover:bg-iosBlue group-hover:border-iosBlue group-hover:-translate-y-1 transition-all duration-300 backdrop-blur-sm shadow-lg"><i :class="soc.icon"></i></div>
                        <span class="text-[10px] text-slate-500 group-hover:text-white uppercase font-bold tracking-wider transition-colors">@{{ soc.name }}</span>
                    </a>
                </div>
            </div>
        </section>

    </main>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
    const { createApp, ref, computed } = Vue;

    createApp({
        setup() {
            const searchQuery = ref('');
            const whatsappLink = "https://wa.me/628123456789"; 
            const activeFaq = ref(0); 

            // 1. DATA PRODUK
            const popularProducts = ref([
                { name: 'Paket Lengkap S.O.P HRD Perusahaan', price: 299000, oldPrice: 500000, rating: 4.9, sold: '1.2k', image: 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&q=80&w=400&h=400' },
                { name: 'Template Laporan Keuangan Excel Otomatis', price: 149000, oldPrice: 250000, rating: 4.8, sold: '890', image: 'https://images.unsplash.com/photo-1554224154-26032ffc0d07?auto=format&fit=crop&q=80&w=400&h=400' },
                { name: 'S.O.P Pelayanan Customer Service', price: 99000, oldPrice: 150000, rating: 4.7, sold: '550', image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=400&h=400' },
                { name: 'Dokumen Legalitas Pendirian PT', price: 499000, oldPrice: 750000, rating: 5.0, sold: '300', image: 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&q=80&w=400&h=400' },
            ]);

            const newProducts = ref([
                { name: 'Form Cuti & Lembur Otomatis', price: 50000, image: 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?auto=format&fit=crop&q=80&w=300&h=300' },
                { name: 'S.O.P Digital Marketing 2024', price: 199000, image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=300&h=300' },
                { name: 'Template KPI Karyawan', price: 89000, image: 'https://images.unsplash.com/photo-1507925921958-8a62f3d1a50d?auto=format&fit=crop&q=80&w=300&h=300' },
                { name: 'S.O.P Kebersihan Kantor', price: 75000, image: 'https://images.unsplash.com/photo-1581578731117-104f2a863a30?auto=format&fit=crop&q=80&w=300&h=300' },
            ]);

            // 2. REALTIME SEARCH LOGIC (COMPUTED)
            const filteredPopular = computed(() => {
                if (!searchQuery.value) return popularProducts.value;
                return popularProducts.value.filter(item => 
                    item.name.toLowerCase().includes(searchQuery.value.toLowerCase())
                );
            });

            const filteredNew = computed(() => {
                if (!searchQuery.value) return newProducts.value;
                return newProducts.value.filter(item => 
                    item.name.toLowerCase().includes(searchQuery.value.toLowerCase())
                );
            });

            // 3. OTHER DATA
            const benefits = [
                { title: "100% Editable", desc: "File format Ms Word & Excel.", icon: "ri-file-edit-line" },
                { title: "Instant Download", desc: "Link otomatis masuk via WA.", icon: "ri-download-cloud-2-line" },
                { title: "Standar ISO", desc: "Sesuai ISO 9001:2015.", icon: "ri-shield-check-line" },
                { title: "Support Admin", desc: "Bantuan jika ada kendala.", icon: "ri-customer-service-2-line" },
            ];

            const mediaLogos = [
                "https://marspedia.id/storage/assets/image/cd2991c61c748e807078cb49130fcd05.png",
                "https://marspedia.id/storage/assets/image/c29a87c135f4a2cfe7b826b37b3c5baa.png",
                "https://marspedia.id/storage/assets/image/07d64e34d5ed60dbf6216e04ed28b08c.png",
                "https://marspedia.id/storage/assets/image/7435c3e65555b20f2b79874433f591d0.png",
                "https://marspedia.id/storage/assets/image/9422273a72bd32a9c0d403cbb835de6f.png",
                "https://marspedia.id/storage/assets/image/22236f271016eaa77d643d463fc733f8.png"
            ];

            const testimonials = [
                { name: "Agus Santoso", text: "Proses pembelian sangat cepat, file langsung terkirim ke WA. Dokumennya rapi banget!" },
                { name: "Rizky Febrian", text: "Sangat membantu untuk perusahaan startup saya yang baru merintis. Template lengkap." },
                { name: "Dinda Ayu", text: "Admin ramah banget diajarin cara editnya. Recommended seller pokoknya." },
                { name: "Budi Jaya", text: "Hemat waktu daripada bikin dari nol. Harganya worth it dengan isinya." },
                { name: "Siti Aminah", text: "Metode pembayaran lengkap QRIS, langsung sat set selesai." }
            ];

            const faqs = [
                { q: "Bagaimana cara melakukan pembelian?", a: "1. Pilih produk yang diinginkan.\n2. Klik tombol beli.\n3. Lakukan pembayaran.\n4. Link download otomatis dikirim ke WhatsApp/Email Anda." },
                { q: "Apakah file bisa diedit?", a: "Ya, 100% bisa diedit. File yang dikirim berformat Microsoft Word (.docx) dan Excel (.xlsx), bukan PDF terkunci." },
                { q: "Apakah ada garansi jika file rusak?", a: "Tentu. Jika link tidak bisa diakses atau file rusak, silakan hubungi admin untuk dikirim ulang secara manual." },
                { q: "Metode pembayaran apa yang tersedia?", a: "Kami menerima pembayaran via Transfer Bank (BCA, Mandiri, BRI, BNI), E-Wallet (GoPay, OVO, Dana), dan QRIS." },
                { q: "Apakah sesuai standar ISO?", a: "Ya, struktur dokumen disusun mengacu pada klausul ISO 9001:2015 untuk memudahkan implementasi sistem manajemen mutu." }
            ];

            const socials = [
                { name: "WA", icon: "ri-whatsapp-fill", link: "#" },
                { name: "FB", icon: "ri-facebook-fill", link: "#" },
                { name: "IG", icon: "ri-instagram-fill", link: "#" },
                { name: "Threads", icon: "ri-threads-fill", link: "#" },
                { name: "TikTok", icon: "ri-tiktok-fill", link: "#" },
                { name: "YT", icon: "ri-youtube-fill", link: "#" },
                { name: "Tele", icon: "ri-telegram-fill", link: "#" },
                { name: "Email", icon: "ri-mail-fill", link: "#" },
            ];

            const formatPrice = (value) => value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            const getInitials = (name) => name.match(/(\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("").toUpperCase();
            const toggleFaq = (index) => activeFaq.value = (activeFaq.value === index) ? null : index;
            const resetSearch = () => searchQuery.value = '';

            return {
                searchQuery, whatsappLink, activeFaq,
                benefits, popularProducts, newProducts, socials,
                mediaLogos, testimonials, faqs,
                filteredPopular, filteredNew,
                formatPrice, getInitials, toggleFaq, resetSearch
            }
        }
    }).mount('#app');
</script>
@endpush
