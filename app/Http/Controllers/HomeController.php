<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function HomePage()
    {
        $category = Category::all();
        return view('users.home', compact('category'));
    }
}
