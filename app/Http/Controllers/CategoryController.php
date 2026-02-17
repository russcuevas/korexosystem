<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Make sure you import the model

class CategoryController extends Controller
{
    public function CategoryPage()
    {
        // Get all categories except rice and add-ons
        $categories = Category::where('is_rice_menu', 0)
            ->where('is_add_ons_menu', 0)
            ->get();

        return view('users.category', compact('categories'));
    }
}
