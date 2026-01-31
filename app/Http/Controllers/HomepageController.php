<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\MediaCoverage;
use App\Models\Testimonial;
use App\Models\QnaSection;
use App\Models\InformationCard;
use App\Models\Product;
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
}
