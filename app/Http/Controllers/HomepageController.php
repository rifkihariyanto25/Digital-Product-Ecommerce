<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\MediaCoverage;
use App\Models\Testimonial;
use App\Models\QnaSection;
use App\Models\InformationCard;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        // Get settings (logo, title, description, whatsapp, socmed)
        $setting = Setting::first();
        
        // Get media coverages (logo liputan)
        $mediaCoverages = MediaCoverage::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        // Get testimonials
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        // Get FAQs
        $faqs = QnaSection::orderBy('id')->get();
        
        // Get information cards
        $informationCards = InformationCard::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        // Get products
        $popularProducts = Product::where('is_active', true)
            ->where('is_popular', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        $newProducts = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        return view('homepage', compact(
            'setting',
            'mediaCoverages',
            'testimonials',
            'faqs',
            'informationCards',
            'popularProducts',
            'newProducts'
        ));
    }
    
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $setting = Setting::first();
        $generalFaqs = QnaSection::orderBy('id')->get();
        
        // Get active vouchers
        $vouchers = Voucher::where('is_active', true)
            ->where('berlaku_dari', '<=', now())
            ->where('berlaku_sampai', '>=', now())
            ->where('jumlah_terpakai', '<', \DB::raw('batas_penggunaan'))
            ->orderByDesc('nilai')
            ->get();
        
        return view('detail-produk', compact('product', 'setting', 'generalFaqs', 'vouchers'));
    }
    
    public function checkout($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $setting = Setting::first();
        
        // Get active vouchers
        $vouchers = Voucher::where('is_active', true)
            ->where('berlaku_dari', '<=', now())
            ->where('berlaku_sampai', '>=', now())
            ->where('jumlah_terpakai', '<', \DB::raw('batas_penggunaan'))
            ->orderByDesc('nilai')
            ->get();
        
        return view('pembayaran', compact('product', 'setting', 'vouchers'));
    }
}
