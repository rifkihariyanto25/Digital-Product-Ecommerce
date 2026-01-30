@extends('layouts.app')

@section('title', 'Checkout - Templatenesia Official')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<style>
    body { background-color: #F5F5F7; color: #1D1D1F; -webkit-font-smoothing: antialiased; }
    [x-cloak] { display: none !important; }

    .glass-header {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    @keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .slide-up { animation: slideInUp 0.5s ease-out forwards; }

    @keyframes scanLine { 0% { top: 0%; opacity: 0; } 50% { opacity: 1; } 100% { top: 100%; opacity: 0; } }
    .scan-line { position: absolute; left: 0; width: 100%; height: 4px; background: #007AFF; box-shadow: 0 0 20px #007AFF; animation: scanLine 2.5s infinite; z-index: 10; }

    @keyframes shimmer { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }
    .animate-shimmer { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to right, transparent 0%, rgba(255,255,255,0.4) 50%, transparent 100%); animation: shimmer 2s infinite; pointer-events: none; }
    
    .invoice-scroll::-webkit-scrollbar { width: 6px; }
    .invoice-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
    .invoice-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    
    /* Accordion Transition */
    .accordion-content { transition: max-height 0.3s ease-out, opacity 0.3s ease-out; max-height: 0; opacity: 0; overflow: hidden; }
    .accordion-content.active { max-height: 1000px; opacity: 1; }
</style>
@endpush

@section('content')
<body class="min-h-screen flex flex-col relative overflow-x-hidden selection:bg-iosBlue/20">

    <header class="fixed top-0 w-full z-50 glass-header transition-all duration-300">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 h-16 sm:h-20 flex items-center justify-between">
            <a href="{{ route('homepage') }}" class="flex items-center gap-2 sm:gap-3 cursor-pointer group">
                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjRzyTdfjkBugSP3Ew_vmkaeMQKl0XnZVR83kFV0LtKJXC4gVF_WTGPS57iCampIjdlGU09l_Ct0hw_2Tx51GiHj5uWr6fTYqzJirf8qpAKhwW0AsM-pYcam74_l25KpFvShEYQdkJ-UnuJQsuiP7qa7Ek85k0MWaF0X0pHGmJZ2imL8IQK9ip5M9s2sW0/s16000/Templatenesia%20Logo.jpg" 
                     class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg object-cover shadow-sm group-hover:scale-105 transition-transform" alt="Templatenesia Logo">
                <div>
                    <h1 class="font-heading font-extrabold text-lg sm:text-xl text-slate-900 leading-none">Template<span class="text-iosPurple">nesia</span>.</h1>
                    <p class="text-[9px] sm:text-[10px] text-slate-500 font-medium tracking-wide">Secure Checkout</p>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <a href="https://wa.me/628123456789" target="_blank" class="flex items-center gap-2 bg-slate-900 hover:bg-iosBlue text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all shadow-lg hover:shadow-xl active:scale-95">
                    <i class="ri-whatsapp-line text-base sm:text-lg"></i>
                    <span class="hidden sm:inline">Bantuan</span>
                </a>
            </div>
        </div>
    </header>

    <div x-data="paymentLogic()" x-init="initPayment()" class="w-full max-w-screen-xl mx-auto px-4 sm:px-6 pt-24 sm:pt-32 pb-32 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10">

            <div class="lg:col-span-7 order-1 space-y-5 sm:space-y-6">
                
                <div x-show="paymentStatus === 'UNPAID'" class="bg-gradient-to-r from-iosBlue to-iosPurple rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 shadow-glow slide-up relative overflow-hidden text-white" style="animation-delay: 0.1s;">
                    <div class="absolute right-0 top-0 w-32 h-32 sm:w-40 sm:h-40 bg-white/20 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="flex flex-row items-center justify-between gap-4 relative z-10">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/20">
                                <i class="ri-timer-flash-line text-xl sm:text-2xl animate-pulse"></i>
                            </div>
                            <div>
                                <p class="text-[10px] sm:text-xs font-bold text-white/80 uppercase tracking-wide">Selesaikan Dalam</p>
                                <p class="text-2xl sm:text-3xl font-heading font-extrabold tracking-tight tabular-nums" x-text="formatTime(timeLeft)"></p>
                            </div>
                        </div>
                        <div class="bg-white/20 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full backdrop-blur-sm border border-white/10">
                            <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                                Menunggu
                            </span>
                        </div>
                    </div>
                </div>

                <div x-show="paymentStatus === 'PAID'" class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-[2rem] p-6 shadow-glow slide-up relative overflow-hidden text-white" x-cloak>
                    <div class="flex flex-row items-center justify-between gap-4 relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/20">
                                <i class="ri-checkbox-circle-line text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white/80 uppercase tracking-wide">Status Pesanan</p>
                                <p class="text-2xl font-bold tracking-tight">Pembayaran Berhasil !</p>
                            </div>
                        </div>
                        <div class="bg-white/20 px-4 py-2 rounded-full backdrop-blur-sm border border-white/10">
                            <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                </span>
                                LUNAS
                            </span>
                        </div>
                    </div>
                </div>

                <div x-show="paymentStatus === 'EXPIRED'" class="bg-slate-900 rounded-[2rem] p-6 shadow-lg slide-up relative overflow-hidden text-white" x-cloak>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/10">
                            <i class="ri-error-warning-line text-2xl text-red-500"></i>
                        </div>
                        <div>
                            <p class="text-lg font-bold">Waktu Pembayaran Habis</p>
                            <p class="text-xs text-slate-400">Silahkan ulangi pemesanan dokumen Anda.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[1.5rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-soft slide-up relative border border-slate-100" style="animation-delay: 0.2s;">
                    
                    <div x-show="paymentStatus === 'PAID'" class="text-center py-6" x-cloak>
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                            <div class="absolute inset-0 rounded-full bg-green-400 animate-ping opacity-20"></div>
                            <i class="ri-file-download-fill text-4xl sm:text-5xl text-green-500"></i>
                        </div>
                        <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mb-2">Terima Kasih!</h2>
                        <p class="text-sm sm:text-base text-slate-500 mb-8 max-w-sm mx-auto leading-relaxed">Dokumen Anda telah siap. Silahkan download file melalui link dibawah ini.</p>
                        
                        <div class="space-y-3">
                            <button @click="downloadProductFile" class="w-full bg-gradient-to-r from-iosBlue to-iosPurple text-white font-bold py-3.5 sm:py-4 rounded-2xl shadow-lg hover:shadow-glow hover:-translate-y-1 transition-all flex items-center justify-center gap-3 active:scale-95 group">
                                <div class="bg-white/20 w-8 h-8 rounded-full flex items-center justify-center group-hover:bg-white/30 transition">
                                    <i class="ri-download-cloud-2-fill text-lg"></i>
                                </div>
                                <span>Download File Produk</span>
                            </button>
                            <button @click="showInvoice = true" class="w-full bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-3.5 sm:py-4 rounded-2xl transition-all flex items-center justify-center gap-2 active:scale-95">
                                <i class="ri-file-list-3-line text-lg text-slate-400"></i> Lihat Invoice
                            </button>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-4">Link download telah dikirim ke Email & WhatsApp.</p>
                    </div>

                    <div x-show="paymentStatus === 'EXPIRED'" class="text-center py-10" x-cloak>
                         <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 grayscale opacity-60">
                            <i class="ri-close-circle-line text-4xl text-slate-500"></i>
                        </div>
                        <h2 class="font-heading font-extrabold text-2xl text-slate-400 mb-2">Invoice Kadaluarsa</h2>
                        <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 bg-slate-100 text-slate-600 px-8 py-3 rounded-full font-bold hover:bg-slate-200 transition mt-4">
                            <i class="ri-refresh-line"></i> Buat Pesanan Baru
                        </a>
                    </div>

                    <div x-show="paymentStatus === 'UNPAID'">
                        
                        <div class="flex items-center justify-between mb-8 border-b border-dashed border-gray-100 pb-6">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 p-2 border border-gray-100 rounded-2xl bg-white shadow-sm flex items-center justify-center">
                                    <img :src="getBankLogoColored(paymentMethod)" class="h-full w-auto object-contain">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Metode Pembayaran</span>
                                    <span class="text-base sm:text-lg font-bold text-slate-900 leading-tight" x-text="getMethodName(paymentMethod)"></span>
                                </div>
                            </div>
                            <button @click="showGuide = true" class="text-iosBlue text-xs font-bold hover:underline flex items-center gap-1">
                                <i class="ri-question-line"></i> Cara Bayar
                            </button>
                        </div>

                        <div x-show="paymentMethod === 'qris'" x-cloak>
                            <div class="flex flex-col items-center">
                                <div class="relative group cursor-pointer w-full max-w-[280px] mx-auto mb-2" @click="toggleZoomQR()">
                                    <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-soft relative overflow-hidden">
                                        <div class="scan-line"></div> 
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" 
                                             class="w-full h-auto object-contain block mx-auto rounded-xl transform scale-105" 
                                             alt="QRIS Code">
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <div class="bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-lg shadow-sm border border-gray-100">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" class="h-5 w-auto">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button @click="downloadQR" class="w-full max-w-xs flex items-center justify-center gap-2 bg-slate-50 hover:bg-slate-100 text-slate-700 px-6 py-3 rounded-xl text-sm font-bold transition shadow-sm border border-slate-200 mb-2 active:scale-95">
                                    <i class="ri-download-cloud-line text-iosBlue text-lg"></i> Simpan QRIS
                                </button>
                                <p class="text-[10px] text-slate-400 mb-4">Scan menggunakan GoPay, OVO, Dana, ShopeePay & M-Banking.</p>
                            </div>
                        </div>

                        <div x-show="['bca','bri','bni','mandiri','bsi','cimb'].includes(paymentMethod)" class="space-y-6" x-cloak>
                            
                            <div class="flex flex-col items-center">
                                <div class="relative w-full max-w-sm mx-auto mb-2 group cursor-pointer transition-transform hover:scale-[1.02]" @click="copyText('88010812345678901234')">
                                    
                                    <div class="absolute inset-0 rounded-[2rem] shadow-xl transform rotate-0 transition-all bg-gradient-to-br"
                                         :class="getBankConfig(paymentMethod).gradient"></div>
                                    
                                    <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
                                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -ml-10 -mb-10 pointer-events-none"></div>
                                    
                                    <div class="relative z-10 p-6 sm:p-7 text-white h-full flex flex-col justify-between min-h-[200px] sm:min-h-[220px]">
                                        
                                        <div class="flex justify-between items-start mb-6">
                                            <img :src="getBankLogoColored(paymentMethod)" class="h-6 sm:h-8 w-auto object-contain brightness-0 invert opacity-90">
                                            
                                            <div class="bg-white/20 backdrop-blur-md border border-white/20 px-3 py-1 rounded-lg">
                                                <p class="text-[9px] sm:text-[10px] font-mono font-bold tracking-widest uppercase text-white">Virtual Account</p>
                                            </div>
                                        </div>

                                        <div class="mb-4 text-center">
                                            <p class="text-xs font-medium tracking-wide mb-2 opacity-80" :class="getBankConfig(paymentMethod).textColor">Nomor Pembayaran</p>
                                            <div class="flex items-center justify-center w-full overflow-hidden">
                                                <p class="text-lg sm:text-2xl font-mono font-bold tracking-widest drop-shadow-sm text-white break-all text-center leading-tight">88010812345678901234</p>
                                            </div>
                                        </div>

                                        <div class="flex justify-center mt-2">
                                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 transition-colors shadow-sm">
                                                <i class="fa-regular fa-copy text-xs text-white"></i> 
                                                <span class="text-xs font-bold text-white">Salin Nomor</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-5 border border-gray-100 flex items-center justify-between shadow-sm">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Tagihan</p>
                                    <p class="text-xl font-bold text-iosBlue" x-text="formatRupiah(totalPrice)"></p>
                                </div>
                                <button @click="copyText(totalPrice)" class="text-slate-500 hover:text-iosBlue transition font-bold text-xs bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-200">Salin Nominal</button>
                            </div>
                        </div>

                        <div class="mt-4 pt-6 border-t border-dashed border-gray-100">
                            <button @click="simulatePayment()" 
                                    :disabled="isLoading"
                                    class="w-full bg-slate-900 hover:bg-iosBlue text-white font-bold py-4 rounded-2xl shadow-lg hover:shadow-glow hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group disabled:opacity-75 disabled:cursor-not-allowed disabled:transform-none">
                                
                                <div class="animate-shimmer" x-show="!isLoading"></div>
                                
                                <span class="relative z-10 flex items-center justify-center gap-2 text-lg font-heading">
                                    <template x-if="isLoading">
                                        <span class="flex items-center gap-3">
                                            <i class="fa-solid fa-circle-notch fa-spin"></i>
                                            <span>Memverifikasi...</span>
                                        </span>
                                    </template>
                                    
                                    <template x-if="!isLoading">
                                        <span class="flex items-center gap-2">
                                            <span>Cek status pembayaran</span>
                                            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                        </span>
                                    </template>
                                </span>
                            </button>
                            <p class="text-[10px] text-center text-slate-400 mt-4 font-medium flex items-center justify-center gap-1.5">
                                <i class="ri-shield-check-fill text-green-500 text-lg"></i> Garansi Uang Kembali & Transaksi Aman
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 order-2">
                <div class="sticky top-24 sm:top-32 space-y-5">
                    
                    <div x-data="{ summaryOpen: true }" class="bg-white rounded-[2rem] shadow-soft overflow-hidden slide-up border border-slate-100" style="animation-delay: 0.05s;">
                        
                        <div class="p-5 sm:p-6 relative border-b border-gray-50">
                            <div class="flex gap-4 items-start">
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl overflow-hidden shrink-0 border border-gray-200 mt-1">
                                    <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&q=80&w=400&h=400" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-heading font-bold text-slate-900 text-sm sm:text-base leading-snug mb-1 break-words">
                                        <span x-text="productName"></span>
                                    </h3>
                                    <div class="flex items-center justify-between mt-2">
                                        <p class="font-extrabold text-iosBlue text-lg leading-tight" x-text="formatRupiah(totalPrice)"></p>
                                        <div class="cursor-pointer text-slate-300 hover:text-iosBlue transition p-1 bg-slate-50 rounded-full w-7 h-7 flex items-center justify-center" @click="summaryOpen = !summaryOpen">
                                            <i class="fa-solid fa-chevron-down transition-transform text-xs" :class="summaryOpen ? 'rotate-180' : ''"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-content bg-slate-50/50" :class="summaryOpen ? 'active' : ''">
                            <div class="p-5 sm:p-6 space-y-2">
                                
                                <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-200 last:border-0">
                                    <span class="text-xs text-slate-500 font-medium shrink-0">ID Referensi</span>
                                    <button class="flex items-center gap-2 group pl-2 max-w-[70%]" @click="copyText('INV-'+orderId)">
                                        <span class="text-sm font-bold text-slate-900 font-mono truncate" x-text="'INV-'+orderId"></span>
                                        <div class="w-6 h-6 rounded-full bg-white border border-gray-100 text-slate-400 flex items-center justify-center group-hover:border-iosBlue group-hover:text-iosBlue transition-all shadow-sm shrink-0">
                                            <i class="fa-regular fa-copy text-[10px]"></i>
                                        </div>
                                    </button>
                                </div>

                                <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-200 last:border-0">
                                    <span class="text-xs text-slate-500 font-medium shrink-0">Email</span>
                                    <button class="flex items-center gap-2 group pl-2 max-w-[75%]" @click="copyText(userEmail)">
                                        <span class="text-sm font-bold text-slate-900 truncate" x-text="userEmail"></span>
                                        <div class="w-6 h-6 rounded-full bg-white border border-gray-100 text-slate-400 flex items-center justify-center group-hover:border-iosBlue group-hover:text-iosBlue transition-all shadow-sm shrink-0">
                                            <i class="fa-regular fa-copy text-[10px]"></i>
                                        </div>
                                    </button>
                                </div>

                                <div class="flex justify-between items-center py-2 last:border-0">
                                    <span class="text-xs text-slate-500 font-medium shrink-0">WhatsApp</span>
                                    <button class="flex items-center gap-2 group pl-2 max-w-[70%]" @click="copyText(userPhone)">
                                        <span class="text-sm font-bold text-slate-900 truncate" x-text="userPhone"></span>
                                        <div class="w-6 h-6 rounded-full bg-white border border-gray-100 text-slate-400 flex items-center justify-center group-hover:border-iosBlue group-hover:text-iosBlue transition-all shadow-sm shrink-0">
                                            <i class="fa-regular fa-copy text-[10px]"></i>
                                        </div>
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-soft slide-up" style="animation-delay: 0.2s;">
                         <div class="flex items-center gap-3 mb-3">
                            <i class="ri-secure-payment-line text-2xl text-iosPurple"></i>
                            <h4 class="font-bold text-sm text-slate-800">Jaminan Keamanan</h4>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Data Anda dienkripsi. Garansi 30 Hari Uang Kembali.
                        </p>
                    </div>

                    <a href="https://wa.me/628123456789" target="_blank" class="block bg-slate-900 hover:bg-iosBlue rounded-[2rem] p-6 text-white shadow-lg relative overflow-hidden group cursor-pointer transition-colors duration-300">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10 group-hover:scale-110 transition-transform"></div>
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white border border-white/10">
                                <i class="ri-customer-service-2-line text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-300 font-medium">Ada Kendala?</p>
                                <p class="text-sm font-bold">Chat Admin Support</p>
                            </div>
                            <i class="ri-arrow-right-up-line ml-auto text-white/50 group-hover:text-white transition"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div x-show="showToast" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-10 scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
             class="fixed bottom-10 left-1/2 transform -translate-x-1/2 z-[100] w-auto max-w-[90%]" x-cloak>
            <div class="bg-slate-900/80 backdrop-blur-md text-white pl-4 pr-6 py-3 rounded-full shadow-2xl flex items-center gap-3 border border-white/10">
                <div class="rounded-full w-6 h-6 flex items-center justify-center text-xs shadow-lg" :class="toastType === 'error' ? 'bg-red-500' : 'bg-green-500'">
                    <i class="fa-solid" :class="toastType === 'error' ? 'fa-xmark' : 'fa-check'"></i>
                </div>
                <span class="font-bold text-sm tracking-wide font-heading" x-text="toastMessage"></span>
            </div>
        </div>

        <div x-show="showGuide" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" x-cloak>
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showGuide = false" x-transition.opacity></div>
            <div class="bg-white w-full max-w-lg rounded-[2rem] shadow-2xl relative z-10 overflow-hidden flex flex-col max-h-[80vh]" x-transition.scale.origin.bottom>
                <div class="p-6 border-b border-gray-100 bg-white flex items-center justify-between">
                    <h3 class="font-heading font-bold text-slate-900 text-lg">Panduan Pembayaran</h3>
                    <button @click="showGuide = false" class="w-8 h-8 rounded-full bg-gray-50 text-slate-500 hover:bg-gray-100 flex items-center justify-center transition"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="overflow-y-auto p-6 bg-slate-50">
                    <div x-show="paymentMethod === 'qris'">
                        <ol class="space-y-6 relative border-l-2 border-iosBlue/20 ml-3 pl-8">
                            <li class="relative"><span class="absolute -left-[39px] bg-iosBlue text-white w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold shadow-md">1</span><p class="text-sm text-slate-900 font-bold mb-1">Buka Aplikasi E-Wallet</p><p class="text-xs text-slate-500">Gunakan GoPay, OVO, Dana, ShopeePay, atau Mobile Banking.</p></li>
                            <li class="relative"><span class="absolute -left-[39px] bg-iosBlue text-white w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold shadow-md">2</span><p class="text-sm text-slate-900 font-bold mb-1">Scan QRIS</p><p class="text-xs text-slate-500">Scan kode QR yang tampil atau upload gambar QRIS.</p></li>
                            <li class="relative"><span class="absolute -left-[39px] bg-iosBlue text-white w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold shadow-md">3</span><p class="text-sm text-slate-900 font-bold mb-1">Selesai</p><p class="text-xs text-slate-500">Pembayaran terkonfirmasi otomatis.</p></li>
                        </ol>
                    </div>
                     <div x-show="['bca','bri','bni','mandiri','bsi','cimb'].includes(paymentMethod)">
                         <ol class="space-y-6 relative border-l-2 border-iosBlue/20 ml-3 pl-8">
                            <li class="relative"><span class="absolute -left-[39px] bg-iosBlue text-white w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold shadow-md">1</span><p class="text-sm text-slate-900 font-bold">Login Mobile Banking</p></li>
                            <li class="relative"><span class="absolute -left-[39px] bg-iosBlue text-white w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold shadow-md">2</span><p class="text-sm text-slate-900 font-bold">Pilih Transfer Virtual Account (VA)</p></li>
                            <li class="relative"><span class="absolute -left-[39px] bg-iosBlue text-white w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold shadow-md">3</span><p class="text-sm text-slate-900 font-bold">Masukkan Nomor Virtual Account (VA)</p></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showInvoice" class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center" x-cloak>
            <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="showInvoice = false" x-transition.opacity></div>
            
            <div class="w-full h-full sm:h-auto sm:max-h-[85vh] sm:w-[800px] relative z-10 flex flex-col bg-white sm:rounded-[2rem] shadow-2xl overflow-hidden transition-all transform">
                
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-white shrink-0 z-20">
                    <h3 class="font-heading font-bold text-slate-900 text-lg">Invoice Resmi</h3>
                    
                    <div class="hidden sm:flex items-center gap-3">
                        <button @click="downloadInvoice" class="bg-iosBlue hover:bg-blue-600 text-white text-xs font-bold py-2.5 px-5 rounded-full transition shadow-lg hover:shadow-glow flex items-center gap-2 active:scale-95">
                            <i class="fa-solid fa-download"></i> Simpan Dokumen
                        </button>
                        <button @click="showInvoice = false" class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition w-9 h-9 flex items-center justify-center"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <button @click="showInvoice = false" class="sm:hidden text-slate-500 p-2 bg-slate-100 rounded-full w-9 h-9 flex items-center justify-center"><i class="fa-solid fa-xmark text-lg"></i></button>
                </div>

                <div class="flex-1 overflow-y-auto bg-slate-100 relative invoice-scroll pb-24 sm:pb-0"> 
                    
                    <div id="invoice-capture" class="bg-white shadow-sm relative text-slate-800 mx-auto w-full max-w-[800px]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        
                        <div class="h-2 w-full bg-gradient-to-r from-iosBlue to-iosPurple"></div>

                        <div class="p-8 sm:p-12">
                            <div class="flex flex-col sm:flex-row justify-between items-start mb-10 border-b border-gray-100 pb-8 gap-6">
                                <div class="w-full sm:w-auto">
                                    <div class="flex items-center gap-2 mb-4">
                                        <h1 class="font-extrabold text-2xl text-slate-900 leading-none">Template<span class="text-iosPurple">nesia</span>.</h1>
                                    </div>
                                    <div class="text-xs text-slate-500 font-medium leading-relaxed">
                                        <p class="font-bold text-slate-900">PT. Templatenesia Digital Solution</p>
                                        <p>Menara Mandiri, Jl. Jenderal Sudirman No.54</p>
                                        <p>Jakarta Selatan, DKI Jakarta</p>
                                        <div class="mt-2 space-y-1">
                                            <p><i class="fa-solid fa-envelope w-4 text-center mr-1 text-iosBlue"></i> admin@templatenesia.com</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-auto text-left sm:text-right">
                                    <h2 class="text-4xl font-extrabold text-slate-100 uppercase tracking-widest leading-none mb-2">INVOICE</h2>
                                    <p class="text-sm font-bold text-slate-800">No: <span class="font-mono" x-text="'INV/2024/'+orderId"></span></p>
                                    <p class="text-xs text-slate-500" x-text="transactionTime"></p>
                                    <div class="mt-4 bg-green-50 text-green-600 px-4 py-1.5 rounded-lg inline-block text-xs font-bold border border-green-100 uppercase tracking-wide">
                                        LUNAS / PAID
                                    </div>
                                </div>
                            </div>

                            <div class="mb-8">
                                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                    <table class="w-full text-sm">
                                        <tbody>
                                            <tr>
                                                <td class="text-slate-500 w-24 py-1 font-medium">Kepada</td>
                                                <td class="text-slate-400 w-4 px-2">:</td>
                                                <td class="font-bold text-slate-900">Pelanggan Terhormat</td>
                                            </tr>
                                            <tr>
                                                <td class="text-slate-500 w-24 py-1 font-medium">Email</td>
                                                <td class="text-slate-400 w-4 px-2">:</td>
                                                <td class="font-bold text-slate-900 break-all" x-text="userEmail"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-slate-500 w-24 py-1 font-medium">Kontak</td>
                                                <td class="text-slate-400 w-4 px-2">:</td>
                                                <td class="font-bold text-slate-900" x-text="userPhone"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mb-8 overflow-x-auto rounded-2xl border border-slate-100">
                                <table class="w-full text-sm min-w-[500px] sm:min-w-0">
                                    <thead>
                                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                            <th class="py-4 px-6 text-left font-bold">Keterangan Produk</th>
                                            <th class="py-4 px-6 text-center font-bold w-16">Qty</th>
                                            <th class="py-4 px-6 text-right font-bold w-32">Harga Satuan</th>
                                            <th class="py-4 px-6 text-right font-bold w-32">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-slate-700">
                                        <tr>
                                            <td class="py-5 px-6 align-top border-b border-slate-50">
                                                <p class="font-bold text-slate-900 text-base" x-text="productName"></p>
                                                <p class="text-xs text-slate-500 mt-1">Format: Ms Word & Excel (Editable)</p>
                                            </td>
                                            <td class="py-5 px-6 text-center align-top font-medium border-b border-slate-50">1</td>
                                            <td class="py-5 px-6 text-right align-top border-b border-slate-50" x-text="formatRupiah(price)"></td>
                                            <td class="py-5 px-6 text-right align-top font-bold text-slate-900 border-b border-slate-50" x-text="formatRupiah(price)"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-8 items-start mb-12">
                                <div class="w-full sm:w-1/2 order-2 sm:order-1">
                                    <div class="p-4 border border-dashed border-slate-200 rounded-xl">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Terbilang:</p>
                                        <p class="text-sm font-serif italic text-slate-800 capitalize leading-relaxed font-medium">
                                            "<span x-text="terbilang(totalPrice)"></span> Rupiah"
                                        </p>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-3 leading-relaxed">
                                        Pembayaran telah diverifikasi secara otomatis oleh sistem payment gateway.
                                    </p>
                                </div>
                                <div class="w-full sm:w-1/2 order-1 sm:order-2">
                                    <div class="space-y-3 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                                        <div class="flex justify-between text-xs text-slate-600">
                                            <span class="font-medium">Sub Total</span>
                                            <span x-text="formatRupiah(price)"></span>
                                        </div>
                                        <div class="flex justify-between text-xs text-slate-600">
                                            <span class="font-medium">Kode Unik</span>
                                            <span x-text="formatRupiah(uniqueCode)"></span>
                                        </div>
                                        <div class="flex justify-between text-xs text-slate-600">
                                            <span class="font-medium">Biaya Layanan</span>
                                            <span x-text="formatRupiah(serviceFee)"></span>
                                        </div>
                                        <div class="h-px bg-slate-200 w-full my-2"></div>
                                        <div class="flex justify-between items-center">
                                            <span class="font-bold text-slate-900 text-sm uppercase">TOTAL BAYAR</span>
                                            <span class="font-extrabold text-2xl text-iosBlue" x-text="formatRupiah(totalPrice)"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-slate-100 pt-6">
                                <div class="flex flex-col sm:flex-row justify-between items-end gap-6">
                                    <div class="w-full sm:w-2/3">
                                        <p class="font-bold text-xs text-slate-800 mb-1">KETENTUAN:</p>
                                        <p class="text-[10px] text-slate-500 leading-relaxed mb-2">
                                            Produk yang sudah dibeli tidak dapat ditukar atau dikembalikan. Mohon simpan invoice ini sebagai bukti pembelian yang sah.
                                        </p>
                                        <p class="text-[10px] text-slate-500 leading-relaxed">
                                            Hak cipta dokumen tetap pada Templatenesia. Dilarang menyebarluaskan atau menjual kembali tanpa izin.
                                        </p>
                                    </div>
                                    <div class="text-center w-full sm:w-auto min-w-[150px]">
                                        <div class="h-16 w-full flex items-center justify-center mb-2">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e4/Signature_sample.svg" class="h-10 opacity-30 grayscale" alt="Signature">
                                        </div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest border-t border-slate-200 pt-1">Finance Dept.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block sm:hidden absolute bottom-0 left-0 w-full bg-white border-t border-gray-100 p-4 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] z-30">
                    <button @click="downloadInvoice" class="w-full bg-iosBlue text-white py-3.5 rounded-full font-bold shadow-lg flex items-center justify-center gap-2 active:scale-95 transition">
                        <i class="fa-solid fa-download"></i> Simpan Invoice (JPG)
                    </button>
                </div>

            </div>
        </div>

    </div>
</body>
@endsection

@push('scripts')
<script>
    function paymentLogic() {
        return {
            paymentStatus: 'UNPAID',
            isLoading: false, 
            timeLeft: 900, 
            paymentMethod: 'qris', 
            productName: 'Paket Lengkap S.O.P HRD & GA (Dokumen Ms Word & Excel Editable)', 
            price: 299000, 
            serviceFee: 2500, 
            uniqueCode: 123, 
            totalPrice: 0,
            userEmail: 'budi.santoso@email.com', 
            userPhone: '0812-3456-7890',
            orderId: Math.floor(100000 + Math.random() * 900000),
            transactionTime: new Date().toLocaleString('id-ID', {day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'}) + ' WIB',
            showInvoice: false, 
            showGuide: false,
            showToast: false, 
            toastMessage: '',
            toastType: 'success', 
            timerInterval: null,

            initPayment() {
                this.totalPrice = this.price + this.serviceFee + this.uniqueCode;
                this.startTimer();
            },

            startTimer() {
                this.timerInterval = setInterval(() => {
                    if (this.timeLeft > 0 && this.paymentStatus === 'UNPAID') {
                        this.timeLeft--;
                    } else if (this.timeLeft <= 0 && this.paymentStatus === 'UNPAID') {
                        this.paymentStatus = 'EXPIRED';
                        clearInterval(this.timerInterval);
                    }
                }, 1000);
            },

            formatTime(seconds) {
                const m = Math.floor(seconds / 60); 
                const s = seconds % 60;
                return `${m}:${s < 10 ? '0' : ''}${s}`;
            },
            
            formatRupiah(number) { 
                return new Intl.NumberFormat('id-ID', { 
                    style: 'currency', 
                    currency: 'IDR', 
                    minimumFractionDigits: 0 
                }).format(number); 
            }
        }
    }
</script>
@endpush
