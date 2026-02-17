<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    #ROUTE : /home - GET METHOD
    public function HomePage()
    {
        $category = Category::where('is_rice_menu', '!=', 1)
            ->where('is_add_ons_menu', '!=', 1)
            ->limit(3)
            ->get();

        return view('users.home', compact('category'));
    }
}
