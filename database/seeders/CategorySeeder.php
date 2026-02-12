<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'Appetizers',
                'category_pic' => 'https://cdn-icons-mp4.flaticon.com/512/13399/13399457.mp4'
            ],
            [
                'category_name' => 'Soup',
                'category_pic' => 'https://cdn-icons-mp4.flaticon.com/512/12053/12053796.mp4'
            ],
            [
                'category_name' => 'Mains',
                'category_pic' => 'https://cdn-icons-mp4.flaticon.com/512/12053/12053796.mp4'
            ],
            [
                'category_name' => 'Sides',
                'category_pic' => 'http://cdn-icons-mp4.flaticon.com/512/15256/15256764.mp4'
            ],
            [
                'category_name' => 'Dessert',
                'category_pic' => 'https://cdn-icons-mp4.flaticon.com/512/11092/11092800.mp4'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
