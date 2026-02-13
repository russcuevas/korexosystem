<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    #ROUTE : /home - GET METHOD
    public function HomePage()
    {
        $category = Category::limit(3)->get();
        return view('users.home', compact('category'));
    }
}
