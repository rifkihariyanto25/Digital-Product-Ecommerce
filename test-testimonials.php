<?php

use App\Models\Product;

$product = Product::find(1);

echo "testimonials type: " . gettype($product->testimonials) . "\n";
echo "testimonials is_array: " . (is_array($product->testimonials) ? 'yes' : 'no') . "\n";

if ($product->testimonials) {
    echo "testimonials count: " . (is_array($product->testimonials) ? count($product->testimonials) : 'not array') . "\n";
    echo "testimonials data: " . print_r($product->testimonials, true) . "\n";
}
