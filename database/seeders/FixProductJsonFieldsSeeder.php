<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixProductJsonFieldsSeeder extends Seeder
{
    public function run(): void
    {
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            $updates = [];
            
            // Fix gallery
            $gallery = $product->gallery;
            if (is_string($gallery)) {
                // Decode hingga dapat array sebenarnya
                while (is_string($gallery)) {
                    $decoded = json_decode($gallery, true);
                    if ($decoded === null) {
                        $gallery = [];
                        break;
                    }
                    $gallery = $decoded;
                }
                $updates['gallery'] = json_encode($gallery ?: []);
            } elseif ($gallery === null) {
                $updates['gallery'] = json_encode([]);
            }
            
            // Fix testimonials
            $testimonials = $product->testimonials;
            if (is_string($testimonials)) {
                while (is_string($testimonials)) {
                    $decoded = json_decode($testimonials, true);
                    if ($decoded === null) {
                        $testimonials = [];
                        break;
                    }
                    $testimonials = $decoded;
                }
                $updates['testimonials'] = json_encode($testimonials ?: []);
            } elseif ($testimonials === null) {
                $updates['testimonials'] = json_encode([]);
            }
            
            // Fix faqs
            $faqs = $product->faqs;
            if (is_string($faqs)) {
                while (is_string($faqs)) {
                    $decoded = json_decode($faqs, true);
                    if ($decoded === null) {
                        $faqs = [];
                        break;
                    }
                    $faqs = $decoded;
                }
                $updates['faqs'] = json_encode($faqs ?: []);
            } elseif ($faqs === null) {
                $updates['faqs'] = json_encode([]);
            }
            
            // Fix bonuses
            $bonuses = $product->bonuses;
            if (is_string($bonuses)) {
                while (is_string($bonuses)) {
                    $decoded = json_decode($bonuses, true);
                    if ($decoded === null) {
                        $bonuses = [];
                        break;
                    }
                    $bonuses = $decoded;
                }
                $updates['bonuses'] = json_encode($bonuses ?: []);
            } elseif ($bonuses === null) {
                $updates['bonuses'] = json_encode([]);
            }
            
            if (!empty($updates)) {
                DB::table('products')->where('id', $product->id)->update($updates);
                $this->command->info("Fixed product ID {$product->id}: " . implode(', ', array_keys($updates)));
            }
        }
        
        $this->command->info('Successfully fixed all product JSON fields!');
    }
}
