<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function AdminMenuPage()
    {
        $menu = Menu::leftJoin('categories', 'menus.category_id', '=', 'categories.id')
            ->select(
                'menus.*',

                'categories.id as cat_id',
                'categories.category_pic',
                'categories.category_name',
                'categories.is_rice_menu',
                'categories.is_add_ons_menu',
                'categories.created_at as cat_created_at',
                'categories.updated_at as cat_updated_at'
            )
            ->get();

        return view('admin.menu', compact('menu'));
    }
}
