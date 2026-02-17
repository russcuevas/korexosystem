<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $MenuCategory = [
            // appetizers
            [
                'category_id' => 1,
                'menu_pic' => null,
                'menu_name' => 'Kimchi Chicken Quezadilla',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'ingredients' => '
                    <h6><i>2 servings</i></h6>
                    <ul>
                        <li>Kimchi - ½ cup</li>
                        <li>Chicken Breast - 1 small size</li>
                        <li>Pita Wrap - 2 pcs.</li>
                        <li>Gochujang - 2 tbsp</li>
                        <li>Cheese - 100/50 grams</li>
                        <li>Cayenne Pepper - 2 tsp</li>
                        <li>Garlic Powder - 2 tsp</li>
                        <li>Honey - 2 tsp</li>
                        <li>Oil - 1 tbsp</li>
                        <li>Salt and pepper to taste</li>
                    </ul>
                ',
            ],
            [
                'category_id' => 1,
                'menu_pic' => null,
                'menu_name' => 'Cajun Corn Elote',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'ingredients' => '
                    <h6><i>3 servings</i></h6>
                    <ul>
                        <li>Sweet Corn - 1 large size</li>
                        <li>Mayonnaise - ¼ cup</li>
                        <li>Parmesan Cheese - 2 tbsp</li>
                        <li>Chili Powder - 1 tsp</li>
                        <li>Cajun Powder - 1 tbsp</li>
                        <li>Cilantro - 1 tsp</li>
                    </ul>
                ',
            ],

            // soup
            [
                'category_id' => 2,
                'menu_pic' => null,
                'menu_name' => 'Tofu Stew',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'ingredients' => '
        <h6><i>10-15 Servings</i></h6>
        <ul>
            <li>Firm Korean Tofu - 1 pack</li>
            <li>Thin Sliced Pork Belly - ½ kg</li>
            <li>Chili powder - 2 tbsp</li>
            <li>Shrimp Paste - 4 tbsp</li>
            <li>Kimchi - 1 cup</li>
            <li>Scallions - 3 haba</li>
            <li>Shitake - 1 pack</li>
            <li>Enoki - 1 pack</li>
            <li>Egg - 2 xl</li>
            <li>Garlic - 1 bulb</li>
            <li>Sesame Oil - 4 tbsp</li>
            <li>Salt and pepper to taste</li>
        </ul>
    ',
            ],
            [
                'category_id' => 2,
                'menu_pic' => null,
                'menu_name' => 'Chicken Tortilla Soup',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'ingredients' => '
                    <h6><i>8 - 10 Servings</i></h6>
                    <ul>
                        <li>Carrots - 2 medium size</li>
                        <li>Celery stalks - 2 pcs</li>
                        <li>Tomato - 4 medium size</li>
                        <li>Chicken w/ bones - 1 kg</li>
                        <li>Corn Kernels - 2 cups</li>
                        <li>Black Beans - 2 cups</li>
                        <li>Cumin - 1 tsp</li>
                        <li>Paprika - 1 tsp</li>
                        <li>Cilantro - 2 pcs</li>
                        <li>Green bell pepper - 1 pc</li>
                        <li>Bay Leaves - 2 pcs</li>
                        <li>Onion - 1 medium size</li>
                        <li>Garlic - bulb</li>
                        <li>Oil - 3 tbsp</li>
                        <li>Pita wrap - 5 pcs.</li>
                        <li>Salt and pepper to taste</li>
                    </ul>
                ',
            ],


            // Mains
            [
                'category_id' => 3,
                'menu_pic' => null,
                'menu_name' => 'Salsa Strips',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'ingredients' => '
        <h6><i>3 Servings</i></h6>
        <ul>
            <li>Beef - 450g</li>
            <li>Tomato - 4 pcs</li>
            <li>Onion - 3 pcs</li>
            <li>Cilantro - 3 pcs</li>
            <li>Calamansi - 5 pcs</li>
            <li>Oil - 3 tbsp</li>
            <li>Salt and Pepper - to taste</li>
        </ul>
    ',
            ],
            [
                'category_id' => 3,
                'menu_pic' => null,
                'menu_name' => 'Bulgogi Strips',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'ingredients' => '
        <h6><i>3 Servings</i></h6>
        <ul>
            <li>Beef - 450g</li>
            <li>Gochujang - 3 tbsp</li>
            <li>Soy Sauce - 2 tbsp</li>
            <li>Honey - 1 tbsp</li>
            <li>Sesame Oil - 1 tbsp</li>
            <li>Garlic - 4 cloves</li>
            <li>Onion - 1 medium size</li>
            <li>Salt and Pepper - to taste</li>
        </ul>
    ',
            ],


            // sides
            [
                'category_id' => 4,
                'menu_pic' => null,
                'menu_name' => 'Buttered Corn',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'ingredients' => '
        <h6><i>4–5 Servings</i></h6>
        <ul>
            <li>Kernel Corn - 1 can</li>
            <li>Butter - ¼ cup</li>
        </ul>
    ',
            ],

            [
                'category_id' => 4,
                'menu_pic' => null,
                'menu_name' => 'Potato Marble',
                'menu_price' => 0.00,
                'stock_number' => 85,
            ],

            //dessert
            [
                'category_id' => 5,
                'menu_pic' => null,
                'menu_name' => 'Watermelon Bingsu with Cheesecake',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'ingredients' => '
        <h6><i>2–3 Servings (Bingsu)</i></h6>
        <ul>
            <li>Fresh Milk (Emborg) - 1 Liter</li>
            <li>Condensed Milk (Cowbell) - ½ can</li>
            <li>Watermelon - ½ kg</li>
            <li>Watermelon Syrup (ZNW) - 1 tsp</li>
        </ul>

        <h6><i>10–12 Servings (Cheesecake)</i></h6>
        <ul>
            <li>Crushed Graham - ¾ cup</li>
            <li>Butter - 4 tbsp</li>
            <li>Cream Cheese - 1 block</li>
            <li>All Purpose Cream - ½ cup</li>
            <li>Vanilla (McCormick) - ½ tsp</li>
            <li>Powdered Sugar - 6 tbsp</li>
            <li>Gelatin (Knox) - ½ sachet</li>
            <li>Salt - ½ tsp</li>
        </ul>
    ',
            ],


            // rice
            [
                'category_id' => 6,
                'menu_pic' => null,
                'menu_name' => 'Plain Rice',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'is_rice_menu' => true,
            ],
            [
                'category_id' => 6,
                'menu_pic' => null,
                'menu_name' => 'Kimchi Fried Rice',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'is_rice_menu' => true,
                'ingredients' => '
        <h6><i>3 Servings</i></h6>
        <ul>
            <li>Kimchi - 1 cup</li>
            <li>Egg - 2 XL</li>
            <li>Butter - 1 tbsp</li>
            <li>Soy Sauce - 1 tbsp</li>
            <li>Sesame Oil - 1 tbsp</li>
            <li>Garlic - 5 cloves</li>
            <li>Rice - 3 cups</li>
            <li>Sesame Seeds - for toppings</li>
            <li>Salt - to taste</li>
        </ul>
    ',
            ],
            [
                'category_id' => 6,
                'menu_pic' => null,
                'menu_name' => 'Mexican Rice',
                'menu_price' => 0.00,
                'stock_number' => 85,
                'is_rice_menu' => true,
                'ingredients' => '
        <h6><i>3 Servings</i></h6>
        <ul>
            <li>Chorizo - ½ cup</li>
            <li>Red Bell Pepper - ½ cup</li>
            <li>Kernel Corn - ½ cup</li>
            <li>Beef Cube - 1 ½ tsp</li>
            <li>Chili Powder - 1 tsp</li>
            <li>Cumin - ½ tsp</li>
            <li>Cilantro - 2 tbsp</li>
            <li>Garlic - 5 cloves</li>
            <li>Calamansi - drizzle</li>
            <li>Salt and Pepper - to taste</li>
            <li>Oil - 3 tbsp</li>
        </ul>
    ',
            ],


            // add-ons
            [
                'category_id' => 7,
                'menu_pic' => null,
                'menu_name' => 'Matcha Latte',
                'menu_price' => 50.00,
                'stock_number' => 85,
                'is_add_ons_menu' => true,
            ],
        ];

        foreach ($MenuCategory as $menu) {
            \App\Models\Menu::create($menu);
        }
    }
}
