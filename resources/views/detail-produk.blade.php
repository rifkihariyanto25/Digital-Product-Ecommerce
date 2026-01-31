@extends('layouts.app')

@section('title', $product->name . ' - Templatenesia Official')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style>
    body { background-color: #F5F5F7; color: #1D1D1F; -webkit-font-smoothing: antialiased; }
    [x-cloak] { display: none !important; }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    html { scroll-padding-bottom: 140px; scroll-padding-top: 100px; }

    .bg-pattern {
        background-image: radial-gradient(#007AFF 1px, transparent 1px);
        background-size: 8px 8px;
    }

    @keyframes bouncy-button {
        0%, 100% { transform: translateY(0); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        50% { transform: translateY(-3px); box-shadow: 0 15px 20px -5px rgba(0, 122, 255, 0.3); }
    }

    .btn-bouncy {
        background: linear-gradient(135deg, #1D1D1F 0%, #007AFF 100%);
        background-size: 200% 200%;
        animation: bouncy-button 3s infinite ease-in-out;
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    @keyframes arrow-jump {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    .icon-jump {
        display: inline-block;
        animation: arrow-jump 1s infinite ease-in-out; 
    }

    .btn-bouncy:hover {
        animation-play-state: paused;
        transform: translateY(-2px);
        filter: brightness(1.1);
    }
</style>
@endpush

@section('content')
@php
    // Decode JSON fields once at the top (or use directly if already array from model cast)
    $gallery = is_array($product->gallery) ? $product->gallery : (is_string($product->gallery) ? json_decode($product->gallery, true) : []);
    $testimonials = is_array($product->testimonials) ? $product->testimonials : (is_string($product->testimonials) ? json_decode($product->testimonials, true) : []);
    $faqs = is_array($product->faqs) ? $product->faqs : (is_string($product->faqs) ? json_decode($product->faqs, true) : []);
    $bonuses = is_array($product->bonuses) ? $product->bonuses : (is_string($product->bonuses) ? json_decode($product->bonuses, true) : []);
    $bonusValue = ($bonuses && is_array($bonuses) && count($bonuses) > 0) ? count($bonuses) * 100000 : 0;
@endphp

<body class="pb-40 lg:pb-32"> 

    <div x-data="{
        timerTime: 1800, 
        timerDisplay: '00 : 30 : 00',
        showCopyToast: false,
        showErrorModal: false,
        
        productName: '{{ $product->name }}',
        productImage: '{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400' }}',
        
        basePrice: {{ $product->discount_price ?: $product->price }},   
        normalPrice: {{ $product->price }}, 
        bonusValue: {{ $bonusValue }}, 
        adminFee: 0,
        uniqueCode: Math.floor(Math.random() * 899) + 100,

        voucherAmount: 0,
        selectedVoucherCode: '',
        availableVouchers: [
            @foreach($vouchers as $index => $voucher)
            { 
                code: '{{ $voucher->kode_voucher }}', 
                amount: {{ $voucher->nilai }}, 
                label: '{{ $voucher->nama_voucher }}', 
                type: '{{ $voucher->tipe }}',
                best: {{ $index === 0 ? 'true' : 'false' }} 
            }{{ $loop->last ? '' : ',' }}
            @endforeach
        ],

        paymentMethod: 'qris', 
        selectedPaymentChannel: 'qris_all', 
        
        formData: { name: '', email: '', phone: '', agreed: true },
        formErrors: { name: false, email: false, phone: false },

        slides: [
            @if($product->image)
            { type: 'image', src: '{{ asset('storage/' . $product->image) }}' },
            @endif
            @if($gallery && is_array($gallery))
                @foreach($gallery as $galleryImage)
                { type: 'image', src: '{{ asset('storage/' . $galleryImage) }}' },
                @endforeach
            @endif
        ],
        active: 0,
        autoplay: null,

        init() {
            this.startTimer();
            const bestVoucher = this.availableVouchers.reduce((prev, current) => (prev.amount > current.amount) ? prev : current);
            if(bestVoucher) { this.selectVoucher(bestVoucher); }
            setTimeout(() => this.triggerPopup(), 3000); 
            setInterval(() => this.triggerPopup(), 60000);
            if(this.slides.length > 0) this.startAutoplay();
        },

        startAutoplay() { this.autoplay = setInterval(() => { this.next(); }, 3000); },
        stopAutoplay() { clearInterval(this.autoplay); },
        next() { this.active = (this.active === this.slides.length - 1) ? 0 : this.active + 1; },
        prev() { this.active = (this.active === 0) ? this.slides.length - 1 : this.active - 1; },

        sanitizeName() {
            let val = this.formData.name.replace(/[^a-zA-Z\s]/g, '');
            if (val.length > 30) val = val.substring(0, 30);
            this.formData.name = val;
            if(val.length > 0) this.formErrors.name = false;
        },
        sanitizeEmail() {
            let val = this.formData.email.replace(/[^a-zA-Z0-9@._]/g, '');
            if (val.length > 50) val = val.substring(0, 50);
            this.formData.email = val;
            if(val.length > 0) this.formErrors.email = false;
        },
        sanitizePhone() {
            let val = this.formData.phone.replace(/[^0-9]/g, '');
            if (val.length > 15) val = val.substring(0, 15);
            this.formData.phone = val;
            if(val.length > 0) this.formErrors.phone = false;
        },

        submitOrder() {
            this.formErrors = { name: false, email: false, phone: false };
            let hasError = false;

            if (!this.formData.name || this.formData.name.trim().length < 2) { this.formErrors.name = true; hasError = true; }
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!this.formData.email || !emailPattern.test(this.formData.email)) { this.formErrors.email = true; hasError = true; }
            if (!this.formData.phone || this.formData.phone.length < 7) { this.formErrors.phone = true; hasError = true; }

            if (hasError) {
                this.showErrorModal = true;
                setTimeout(() => {
                    const formElement = document.getElementById('buyer-form-start');
                    if(formElement) formElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 300);
                return;
            }

            // Redirect ke halaman pembayaran dengan data di URL params
            const params = new URLSearchParams({
                name: this.formData.name,
                email: this.formData.email,
                phone: this.formData.phone,
                payment: this.selectedPaymentChannel,
                voucher: this.selectedVoucherCode || ''
            });
            window.location.href = '{{ route('product.checkout', $product->id) }}?' + params.toString();
        },

        get grandTotal() { return Math.max(0, this.basePrice + this.uniqueCode - this.voucherAmount); },
        get productDiscount() { return this.normalPrice - this.basePrice; },
        get totalSavings() { return this.productDiscount + this.bonusValue + this.voucherAmount; },
        formatRupiah(number) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number); },
        selectVoucher(voucher) { 
            this.selectedVoucherCode = voucher.code; 
            if (voucher.type === 'persentase') {
                // Hitung persentase dari base price
                this.voucherAmount = Math.round(this.basePrice * (voucher.amount / 100));
            } else {
                // Nominal langsung
                this.voucherAmount = voucher.amount;
            }
        },
        selectPayment(channel, methodType) { this.selectedPaymentChannel = channel; this.paymentMethod = methodType; },
        startTimer() { setInterval(() => { if (this.timerTime > 0) { this.timerTime--; let h = Math.floor(this.timerTime / 3600).toString().padStart(2, '0'); let m = Math.floor((this.timerTime % 3600) / 60).toString().padStart(2, '0'); let s = (this.timerTime % 60).toString().padStart(2, '0'); this.timerDisplay = `${h} : ${m} : ${s}`; } }, 1000); },
        copyText(text) { const cleanText = text.toString().replace(/[^0-9]/g, ''); navigator.clipboard.writeText(cleanText).then(() => { this.showCopyToast = true; setTimeout(() => { this.showCopyToast = false; }, 3000); }); },
        
        showPopup: false, popupBuyerName: '', popupTime: '', buyers: ['Andi', 'Budi', 'Siti', 'Dewi', 'Rizky', 'Putri', 'Sarah', 'Reza'],
        triggerPopup() { const now = new Date(); const hours = String(now.getHours()).padStart(2, '0'); const minutes = String(now.getMinutes()).padStart(2, '0'); this.popupBuyerName = this.buyers[Math.floor(Math.random() * this.buyers.length)]; this.popupTime = `${hours}.${minutes}`; this.showPopup = true; setTimeout(() => { this.showPopup = false }, 5000); }
     }">

        <header class="fixed top-0 w-full z-50 glass-effect transition-all duration-300 shadow-sm">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
                <a href="{{ route('homepage') }}" class="flex items-center gap-3 cursor-pointer group">
                    @if($setting && $setting->logo_header_atas)
                    <img src="{{ asset('storage/' . $setting->logo_header_atas) }}" class="w-10 h-10 rounded-lg object-cover shadow-sm group-hover:scale-105 transition-transform" alt="Logo">
                    @endif
                    <div>
                        <h1 class="font-heading font-extrabold text-xl text-slate-900 leading-none">{{ $setting->judul_header_atas ?? 'Templatenesia' }}</h1>
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    <div x-data="{ 
                            viewers: 65,
                            init() {
                                this.viewers = Math.floor(Math.random() * (95 - 51 + 1)) + 51;
                                setInterval(() => { this.viewers = Math.floor(Math.random() * (95 - 51 + 1)) + 51; }, 15000); 
                            }
                         }" 
                         class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-white rounded-full border border-slate-200 shadow-sm text-xs font-medium text-slate-500 animate-fade-in-up">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span><b x-text="viewers" class="text-slate-900"></b> orang sedang melihat halaman ini</span>
                    </div>

                    <a href="#" class="flex items-center gap-2 bg-slate-900 hover:bg-iosBlue text-white px-5 py-2.5 rounded-full text-sm font-semibold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:scale-95">
                        <i class="ri-customer-service-2-line text-lg"></i>
                        <span class="hidden sm:inline">Bantuan</span>
                    </a>
                </div>
            </div>
        </header>

        <main class="w-full max-w-screen-xl mx-auto px-4 sm:px-6 pt-24 lg:pt-28">

            <div class="md:hidden w-full flex justify-center mb-6 mt-4">
                 <div x-data="{ 
                        viewers: 65,
                        init() {
                            this.viewers = Math.floor(Math.random() * (95 - 51 + 1)) + 51;
                            setInterval(() => { this.viewers = Math.floor(Math.random() * (95 - 51 + 1)) + 51; }, 15000); 
                        }
                     }" 
                     class="inline-flex items-center gap-2 text-xs font-medium text-slate-600 bg-white px-4 py-2 rounded-full border border-slate-200 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span><b x-text="viewers" class="text-slate-900"></b> orang sedang melihat halaman ini</span>
                </div>
            </div>

            <div class="mb-8 relative overflow-hidden rounded-[2rem] shadow-red-glow animate-fade-in-up">
                <div class="bg-gradient-to-r from-red-600 via-orange-500 to-red-500 bg-[length:200%_200%] animate-[gradient_3s_ease_infinite] text-white p-5 flex flex-col md:flex-row items-center justify-between relative z-10">
                    <div class="flex items-center gap-3 mb-2 md:mb-0">
                        <div class="bg-white/20 p-2 rounded-full flex items-center justify-center">
                            <i class="ri-timer-flash-fill text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-red-100">JANGAN SAMPAI KEHABISAN!</p>
                            <h3 class="font-bold text-lg leading-none">Promo Berakhir Dalam Waktu:</h3>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-6 py-2 rounded-xl border border-white/20">
                         <div class="text-2xl font-mono font-black tracking-widest text-white drop-shadow-sm" x-text="timerDisplay"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start relative">

                <div class="lg:col-span-7 space-y-10 animate-fade-in-up delay-100 pb-10">
                    
                    {{-- Gallery Slider --}}
                    <div @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()" class="bg-white p-3 rounded-[2rem] shadow-soft border border-slate-100 relative group overflow-hidden w-full">
                        
                        <div class="relative w-full h-[400px] lg:h-[550px] overflow-hidden rounded-[1.5rem] bg-gray-50 border border-slate-50">
                             <template x-for="(slide, index) in slides" :key="index">
                                <div x-show="active === index" 
                                     x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100" 
                                     class="absolute inset-0 w-full h-full flex items-center justify-center p-2">
                                    <img :src="slide.src" class="w-full h-full object-contain drop-shadow-sm rounded-lg">
                                </div>
                            </template>
                            <button @click="prev()" class="absolute top-1/2 left-4 -translate-y-1/2 z-30 bg-white/90 hover:bg-white text-slate-800 w-10 h-10 flex items-center justify-center rounded-full shadow-lg transition-all opacity-0 group-hover:opacity-100 transform hover:scale-110"><i class="fa-solid fa-chevron-left"></i></button>
                            <button @click="next()" class="absolute top-1/2 right-4 -translate-y-1/2 z-30 bg-white/90 hover:bg-white text-slate-800 w-10 h-10 flex items-center justify-center rounded-full shadow-lg transition-all opacity-0 group-hover:opacity-100 transform hover:scale-110"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>

                    {{-- Deskripsi Produk --}}
                    <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-soft">
                        <h3 class="font-heading text-xl font-bold text-slate-900 mb-6 border-l-4 border-iosBlue pl-4">Tentang Produk Ini</h3>
                        <div class="prose prose-slate max-w-none text-slate-500 leading-relaxed mb-6">
                            <p>{{ $product->description }}</p>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-center hover:bg-blue-50 hover:border-blue-100 transition-colors group">
                                <div class="w-12 h-12 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform"><i class="fa-solid fa-file-word text-blue-600 text-xl"></i></div>
                                <h4 class="font-bold text-slate-900 text-sm mb-1">File Editable</h4><p class="text-[10px] text-slate-400">Word, Excel, PDF</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-center hover:bg-blue-50 hover:border-blue-100 transition-colors group">
                                <div class="w-12 h-12 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform"><i class="fa-solid fa-shield-halved text-iosPurple text-xl"></i></div>
                                <h4 class="font-bold text-slate-900 text-sm mb-1">Standard ISO</h4><p class="text-[10px] text-slate-400">Premium Quality</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-center hover:bg-blue-50 hover:border-blue-100 transition-colors group">
                                <div class="w-12 h-12 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform"><i class="fa-solid fa-money-bill-wave text-green-500 text-xl"></i></div>
                                <h4 class="font-bold text-slate-900 text-sm mb-1">Garansi 100%</h4><p class="text-[10px] text-slate-400">Uang Kembali</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-center hover:bg-blue-50 hover:border-blue-100 transition-colors group">
                                <div class="w-12 h-12 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform"><i class="fa-solid fa-headset text-orange-500 text-xl"></i></div>
                                <h4 class="font-bold text-slate-900 text-sm mb-1">Support 24/7</h4><p class="text-[10px] text-slate-400">Bantuan Admin</p>
                            </div>
                        </div>
                    </div>

                    {{-- Testimoni --}}
                    @if($testimonials && is_array($testimonials) && count($testimonials) > 0)
                    @php
                        $testimonialsData = array_map(function($testi) {
                            return [
                                'name' => $testi['name'] ?? '',
                                'role' => $testi['position'] ?? 'Customer',
                                'text' => $testi['content'] ?? '',
                                'initial' => substr($testi['name'] ?? 'U', 0, 1)
                            ];
                        }, $testimonials);
                    @endphp
                    <div x-data="{
                            testimonials: {{ json_encode($testimonialsData) }},
                            current: 0,
                            autoplay: null,
                            init() { this.startAutoplay(); },
                            startAutoplay() { this.autoplay = setInterval(() => { this.next(); }, 3000); }, 
                            stopAutoplay() { clearInterval(this.autoplay); },
                            next() { this.current = (this.current === this.testimonials.length - 1) ? 0 : this.current + 1; },
                            prev() { this.current = (this.current === 0) ? this.testimonials.length - 1 : this.current - 1; }
                        }"
                        @mouseenter="stopAutoplay()" 
                        @mouseleave="startAutoplay()"
                        class="bg-white border border-slate-100 p-6 md:p-8 rounded-[2rem] shadow-soft relative overflow-hidden group hover:border-blue-100 transition-colors">
                        
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-heading text-lg font-bold text-slate-900">Apa Kata Mereka?</h3>
                            <div class="flex gap-2">
                                <button @click="prev()" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-iosBlue hover:text-white transition-colors flex items-center justify-center"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                                <button @click="next()" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-iosBlue hover:text-white transition-colors flex items-center justify-center"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                            </div>
                        </div>

                        <div class="relative min-h-[140px]">
                            <template x-for="(testi, index) in testimonials" :key="index">
                                <div x-show="current === index" 
                                     x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" 
                                     class="absolute inset-0">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-iosBlue to-iosPurple flex items-center justify-center text-white font-bold text-sm shadow-md" x-text="testi.initial"></div>
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-sm" x-text="testi.name"></h4>
                                            <div class="text-yellow-400 text-xs flex gap-0.5"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                        </div>
                                    </div>
                                    <p class="text-slate-500 italic leading-relaxed text-sm bg-slate-50 p-4 rounded-xl rounded-tl-none">"<span x-text="testi.text"></span>"</p>
                                </div>
                            </template>
                        </div>
                    </div>
                    @endif

                    {{-- FAQ --}}
                    @if($generalFaqs && $generalFaqs->count() > 0)
                    <div x-data="{ active: 0 }" class="bg-white rounded-[2rem] border border-slate-100 shadow-soft overflow-hidden">
                        <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                            <h3 class="font-heading text-lg font-bold text-slate-900 flex items-center gap-2"><i class="ri-question-answer-line text-iosBlue"></i> Pertanyaan Umum</h3>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach($generalFaqs as $index => $faq)
                                <div class="group">
                                    <button @click="active === {{ $index }} ? active = null : active = {{ $index }}" class="w-full flex items-center justify-between p-5 text-left font-semibold text-slate-800 hover:bg-blue-50/30 transition-colors">
                                        <span class="text-sm">{{ $faq->question }}</span>
                                        <i class="fa-solid fa-chevron-down transition-transform duration-300 text-slate-400 text-xs" :class="{'rotate-180 text-iosBlue': active === {{ $index }}}"></i>
                                    </button>
                                    <div x-show="active === {{ $index }}" class="px-5 pb-5 text-sm text-slate-500 leading-relaxed bg-blue-50/10"><p>{{ $faq->answer }}</p></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Bonus --}}
                    @if($bonuses && is_array($bonuses) && count($bonuses) > 0)
                    <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
                        <div class="absolute top-0 right-0 w-80 h-80 bg-iosBlue opacity-20 rounded-full blur-[80px] pointer-events-none animate-pulse"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-6 border-b border-white/10 pb-4">
                                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-xl animate-float">🎁</div>
                                <h3 class="font-heading text-xl font-bold">Bonus Spesial Hari Ini</h3>
                            </div>
                            <div class="space-y-3 mb-8">
                                @foreach($bonuses as $bonus)
                                <div class="bg-white/5 p-3 rounded-xl flex justify-between items-center border border-white/5 hover:bg-white/10 transition-colors">
                                    <div class="flex items-center gap-3"><i class="ri-checkbox-circle-fill text-green-400 text-lg"></i><span class="font-medium text-slate-200 text-sm">{{ $bonus['title'] }}</span></div>
                                    <span class="text-[9px] font-bold bg-white/10 text-white px-2 py-1 rounded">GRATIS</span>
                                </div>
                                @endforeach
                            </div>
                            <div class="bg-gradient-to-r from-iosBlue to-iosPurple rounded-xl p-5 text-center shadow-lg">
                                <p class="text-white/80 text-[10px] uppercase tracking-wider mb-1">HEMAT HINGGA</p>
                                <div class="flex items-center justify-center gap-3"><span class="text-white/50 line-through text-sm">Rp {{ number_format($bonusValue, 0, ',', '.') }}</span><span class="text-2xl font-extrabold text-white">GRATIS HARI INI</span></div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar Checkout --}}
                <div class="lg:col-span-5 relative animate-fade-in-up delay-200 sticky top-28 self-start">
                    <div class="space-y-5">
                        
                        <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-soft relative overflow-hidden">
                            <h3 class="font-heading text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-50 uppercase tracking-wide">Ringkasan Pesanan</h3>
                            <div class="flex gap-4 mb-6">
                                <div class="w-16 h-16 bg-slate-50 rounded-xl flex-shrink-0 overflow-hidden border border-slate-100">
                                    <img :src="productImage" class="w-full h-full object-contain bg-gray-50">
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900 leading-snug mb-1" x-text="productName"></h4>
                                    <p class="text-iosBlue font-bold text-lg" x-text="formatRupiah(basePrice)"></p>
                                    <p class="text-slate-400 text-xs line-through" x-text="formatRupiah(normalPrice)"></p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-xs font-bold text-slate-400 mb-3 flex items-center gap-2 uppercase tracking-wide"><i class="ri-ticket-2-fill text-iosPurple"></i> Voucher Promo</h4>
                                <div class="space-y-3">
                                    <template x-for="voucher in availableVouchers" :key="voucher.code">
                                        <div @click="selectVoucher(voucher)" 
                                             class="relative overflow-visible border rounded-xl flex items-stretch cursor-pointer transition-all duration-300 group h-[60px]"
                                             :class="selectedVoucherCode === voucher.code ? 'border-iosBlue bg-blue-50/50 ring-1 ring-iosBlue shadow-md scale-[1.02]' : 'border-slate-200 bg-white hover:border-blue-200'">
                                            <div x-show="voucher.best" class="absolute -top-2.5 -right-2 z-20"><div class="bg-gradient-to-r from-pink-500 to-red-500 text-white text-[8px] font-bold px-2 py-1 rounded-full shadow-md animate-bounce">🔥 BEST DEAL</div></div>
                                            <div class="absolute inset-0 bg-pattern opacity-10 pointer-events-none rounded-xl" x-show="selectedVoucherCode === voucher.code"></div>
                                            <div class="w-[70px] flex flex-col items-center justify-center p-1 text-center relative z-10 border-r border-dashed" :class="selectedVoucherCode === voucher.code ? 'border-iosBlue/30' : 'border-slate-200'">
                                                <span class="text-[8px] font-bold text-slate-400 uppercase">HEMAT</span>
                                                <span class="text-xs font-black text-slate-800" x-text="voucher.type === 'persentase' ? voucher.amount + '%' : formatRupiah(voucher.amount).replace(',00', '').replace('Rp', '')"></span>
                                            </div>
                                            <div class="flex-1 px-3 flex items-center justify-between relative z-10"><div><h5 class="font-bold text-slate-900 text-xs" x-text="voucher.code"></h5><p class="text-[9px] text-slate-500 truncate w-32" x-text="voucher.label"></p></div><div class="w-5 h-5 rounded-full border flex items-center justify-center transition-all" :class="selectedVoucherCode === voucher.code ? 'bg-iosBlue border-iosBlue' : 'border-slate-300 bg-white'"><i x-show="selectedVoucherCode === voucher.code" class="ri-check-line text-white text-xs"></i></div></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            
                            <div class="space-y-2 pt-4 border-t border-slate-100">
                                <div class="flex justify-between text-xs text-slate-500"><span>Harga Normal:</span><span x-text="formatRupiah(normalPrice)"></span></div>
                                <div class="flex justify-between text-xs text-green-600"><span>Diskon Produk:</span><span x-text="'- ' + formatRupiah(productDiscount)"></span></div>
                                <div x-show="selectedVoucherCode" class="flex justify-between text-xs text-iosPurple font-bold"><span>Voucher:</span><span x-text="'- ' + formatRupiah(voucherAmount)"></span></div>
                                <div class="flex justify-between text-xs text-slate-500"><span>Kode Unik:</span><span class="font-mono bg-slate-100 px-1 rounded text-slate-800 font-bold" x-text="'+ ' + uniqueCode"></span></div>
                                <div class="flex justify-between items-center mt-4 pt-4 border-t border-dashed border-slate-200"><span class="text-sm font-bold text-slate-900">Total Tagihan:</span><div class="flex items-center gap-2"><span class="text-xl font-heading font-extrabold text-iosBlue" x-text="formatRupiah(grandTotal)"></span><button @click="copyText(grandTotal)" class="text-slate-400 hover:text-iosBlue transition"><i class="ri-file-copy-line"></i></button></div></div>
                            </div>
                        </div>

                        <div id="buyer-info" class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-soft">
                            <h3 id="buyer-form-start" class="font-heading text-sm font-bold text-slate-900 mb-5 uppercase tracking-wide">Data Pembelian</h3>
                            
                            <div class="space-y-4 mb-6">
                                <div class="relative">
                                    <i class="ri-user-smile-line absolute top-3.5 left-4 text-slate-400"></i>
                                    <input type="text" x-model="formData.name" @input="sanitizeName()" class="w-full pl-10 pr-4 py-3 rounded-xl border bg-slate-50 focus:bg-white outline-none transition text-sm font-medium" :class="formErrors.name ? 'border-red-500 ring-1 ring-red-200' : 'border-slate-200 focus:border-iosBlue focus:ring-2 focus:ring-blue-100'" placeholder="Nama Lengkap">
                                </div>
                                <div class="relative">
                                    <i class="ri-mail-line absolute top-3.5 left-4 text-slate-400"></i>
                                    <input type="email" x-model="formData.email" @input="sanitizeEmail()" class="w-full pl-10 pr-4 py-3 rounded-xl border bg-slate-50 focus:bg-white outline-none transition text-sm font-medium" :class="formErrors.email ? 'border-red-500 ring-1 ring-red-200' : 'border-slate-200 focus:border-iosBlue focus:ring-2 focus:ring-blue-100'" placeholder="Alamat Email">
                                </div>
                                <div class="relative">
                                    <i class="ri-whatsapp-line absolute top-3.5 left-4 text-slate-400"></i>
                                    <input type="tel" x-model="formData.phone" @input="sanitizePhone()" class="w-full pl-10 pr-4 py-3 rounded-xl border bg-slate-50 focus:bg-white outline-none transition text-sm font-medium" :class="formErrors.phone ? 'border-red-500 ring-1 ring-red-200' : 'border-slate-200 focus:border-iosBlue focus:ring-2 focus:ring-blue-100'" placeholder="No. WhatsApp (08xx)">
                                </div>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-xs font-bold text-slate-400 mb-3 uppercase tracking-wide">Pilih Metode Pembayaran</h4>
                                <div class="space-y-3">
                                    <div @click="selectPayment('qris_all', 'qris')" 
                                         class="border rounded-xl p-3 cursor-pointer flex items-center gap-3 transition-all relative overflow-hidden"
                                         :class="selectedPaymentChannel === 'qris_all' ? 'border-iosBlue border-2 bg-blue-50/50' : 'border-slate-200 hover:bg-slate-50'">
                                        <div x-show="selectedPaymentChannel === 'qris_all'" class="absolute top-0 right-0 bg-iosBlue text-white text-xs w-6 h-6 rounded-bl-xl flex items-center justify-center"><i class="ri-check-line font-bold"></i></div>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" class="h-6 w-auto object-contain">
                                        <div><p class="text-xs font-bold text-slate-800">QRIS All Payment</p><p class="text-[9px] text-slate-500">GoPay, OVO, Dana, ShopeePay</p></div>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-500 mb-2">Virtual Account (Verifikasi Otomatis)</p>
                                        <div class="grid grid-cols-3 gap-2">
                                            <template x-for="bank in [{id:'bca', img:'https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg'},{id:'bri', img:'https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg'},{id:'bni', img:'https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg'},{id:'mandiri', img:'https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg'},{id:'bsi', img:'https://upload.wikimedia.org/wikipedia/commons/a/a0/Bank_Syariah_Indonesia.svg'},{id:'cimb', img:'https://upload.wikimedia.org/wikipedia/commons/b/b1/Bank_CIMB_Niaga_logo.svg'},{id:'danamon', img:'https://upload.wikimedia.org/wikipedia/commons/7/77/Danamon_Bank_logo.svg'},{id:'permata', img:'https://upload.wikimedia.org/wikipedia/commons/b/b5/PermataBank_logo_2024.svg'},{id:'btn', img:'https://upload.wikimedia.org/wikipedia/commons/2/2e/Bank_BTN_logo_2019.svg'}]">
                                                <div @click="selectPayment('va_' + bank.id, 'va')" 
                                                     class="border rounded-xl p-2 cursor-pointer flex flex-col items-center justify-center gap-1 transition-all h-14 bg-white relative overflow-hidden group"
                                                     :class="selectedPaymentChannel === 'va_' + bank.id ? 'border-iosBlue border-2 bg-blue-50/20' : 'border-slate-200 hover:border-blue-200'">
                                                    <div x-show="selectedPaymentChannel === 'va_' + bank.id" class="absolute top-0 right-0 bg-iosBlue text-white text-[10px] w-5 h-5 rounded-bl-lg flex items-center justify-center"><i class="ri-check-line"></i></div>
                                                    <img :src="bank.img" class="h-4 w-auto object-contain max-w-[80%] filter group-hover:brightness-110">
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-slate-100">
                                <div id="agree-section" class="mb-4">
                                    <label class="flex items-start gap-2 cursor-pointer">
                                        <input type="checkbox" id="agree" x-model="formData.agreed" class="mt-0.5 w-4 h-4 text-iosBlue rounded border-slate-300 focus:ring-iosBlue">
                                        <span class="text-[10px] text-slate-500 leading-snug">Saya menyetujui <span class="font-bold text-slate-700">Syarat & Ketentuan</span> pembelian.</span>
                                    </label>
                                </div>
                                <button @click="submitOrder()" class="btn-bouncy w-full bg-slate-900 text-white font-heading font-bold py-4 px-6 rounded-xl shadow-lg transition-all text-lg flex items-center justify-center gap-2 group"><span>Bayar Sekarang</span><i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform icon-jump"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>

        {{-- Modals --}}
        <div x-show="showErrorModal" class="fixed inset-0 z-[100] flex items-center justify-center px-4" x-cloak>
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" @click="showErrorModal = false"></div>
            <div class="bg-white rounded-[2rem] p-6 max-w-sm w-full relative z-10 shadow-2xl animate-pop-in text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-error-warning-fill text-3xl text-red-500"></i>
                </div>
                <h3 class="font-heading text-xl font-bold text-slate-900 mb-2">Mohon Lengkapi Data</h3>
                <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                    Pastikan Anda telah mengisi <b>Data Pembelian</b> dengan benar dan valid sebelum melanjutkan pembayaran.
                </p>
                <button @click="showErrorModal = false" class="w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-iosBlue transition-colors shadow-lg">
                    Oke, Saya Mengerti
                </button>
            </div>
        </div>

        <div x-show="showCopyToast" x-transition class="fixed top-24 left-1/2 transform -translate-x-1/2 z-[100] bg-slate-900 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-3 text-sm font-medium" x-cloak>
            <i class="ri-checkbox-circle-fill text-green-400 text-lg"></i> <span>Berhasil disalin!</span>
        </div>

        <div x-show="showPopup" x-transition class="fixed bottom-32 left-4 md:left-8 z-[90] bg-white rounded-2xl shadow-2xl border border-slate-100 p-4 flex items-center gap-4 max-w-sm md:max-w-md" x-cloak>
            <div class="w-14 h-14 bg-slate-50 rounded-xl flex-shrink-0 overflow-hidden border border-slate-100">
                <img :src="productImage" class="w-full h-full object-contain bg-gray-50">
            </div>
            <div>
                <p class="text-[10px] text-slate-400 mb-0.5">Baru saja membeli</p>
                <div class="flex items-center gap-1 mb-0.5">
                    <p class="text-sm font-bold text-slate-900 leading-tight">
                        <span x-text="popupBuyerName"></span> • <span class="text-[11px] text-slate-500 font-normal" x-text="popupTime"></span>
                    </p>
                </div>
                <p class="text-[10px] text-iosBlue font-bold truncate max-w-[200px]" x-text="productName"></p>
            </div>
        </div>

        {{-- Sticky Footer --}}
        <div class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-slate-200 p-3 sm:p-4 shadow-[0_-5px_30px_rgba(0,0,0,0.08)] z-50">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
                <div class="grid grid-cols-12 gap-8 items-center">
                    
                    <div class="hidden lg:flex col-span-7 items-center gap-5">
                        <div class="w-14 h-14 rounded-lg overflow-hidden border border-slate-200 bg-gray-50 flex-shrink-0 shadow-sm">
                            <img :src="productImage" class="w-full h-full object-contain">
                        </div>
                        <div class="flex flex-col justify-center">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs text-slate-400 line-through" x-text="formatRupiah(normalPrice)"></span>
                                <span class="text-[10px] bg-red-100 text-red-600 px-1.5 rounded font-bold" x-text="timerDisplay"></span>
                            </div>
                            <span class="text-2xl font-heading font-extrabold text-iosBlue leading-none" x-text="formatRupiah(grandTotal)"></span>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-5 w-full flex items-center justify-between lg:justify-end gap-3">
                        <div class="flex flex-col lg:hidden">
                            <div class="flex items-center gap-1.5 mb-0.5">
                                <span class="text-[10px] text-slate-400 line-through" x-text="formatRupiah(normalPrice)"></span>
                                <span class="text-[10px] bg-red-100 text-red-600 px-1 rounded font-bold" x-text="timerDisplay"></span>
                            </div>
                            <span class="text-lg font-extrabold text-iosBlue leading-none" x-text="formatRupiah(grandTotal)"></span>
                        </div>

                        <button @click="submitOrder()" 
                                class="btn-bouncy bg-slate-900 text-white font-bold py-4 px-6 rounded-xl text-lg shadow-lg hover:bg-iosBlue transition-colors flex items-center justify-center gap-2 flex-grow sm:flex-grow-0 min-w-[140px] lg:w-full">
                            <span>Beli Sekarang</span>
                            <i class="ri-arrow-right-line icon-jump"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</body>
@endsection
