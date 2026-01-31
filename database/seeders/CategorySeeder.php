<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Programming & Development', 'slug' => 'programming-development'],
            ['name' => 'Web Design & UI/UX', 'slug' => 'web-design-ui-ux'],
            ['name' => 'Digital Marketing', 'slug' => 'digital-marketing'],
            ['name' => 'Business & Entrepreneurship', 'slug' => 'business-entrepreneurship'],
            ['name' => 'Graphic Design', 'slug' => 'graphic-design'],
            ['name' => 'Video Editing & Animation', 'slug' => 'video-editing-animation'],
            ['name' => 'Data Science & AI', 'slug' => 'data-science-ai'],
            ['name' => 'Mobile App Development', 'slug' => 'mobile-app-development'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
