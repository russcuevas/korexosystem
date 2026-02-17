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
                'category_pic' => 'deviled-eggs.gif'
            ],
            [
                'category_name' => 'Soup',
                'category_pic' => 'soup.gif'
            ],
            [
                'category_name' => 'Main',
                'category_pic' => 'healthy-meal.gif'
            ],
            [
                'category_name' => 'Sides',
                'category_pic' => 'corn.gif'
            ],
            [
                'category_name' => 'Dessert',
                'category_pic' => 'pancake.gif'
            ],
            [
                'category_name' => 'Rice',
                'is_rice_menu' => true,
            ],
            [
                'category_name' => 'Drinks',
                'is_add_ons_menu' => true,
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
