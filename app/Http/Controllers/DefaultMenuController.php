<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DefaultMenuController extends Controller
{
    public function DefaultMenuPage($category_id)
    {
        if (!session()->has('reference_number')) {
            return redirect()->route('reference.number.page');
        }

        $referenceNumber = session('reference_number');

        $ticket = Ticket::where('reference_number', $referenceNumber)->first();

        // If ticket not found
        if (!$ticket) {
            session()->forget(['verified_reference', 'reference_number']);
            return redirect()->route('reference.number.page')
                ->with('error', 'Invalid reference number.');
        }

        // 🚨 If ticket already used
        if ($ticket->is_used == 1) {
            session()->forget(['verified_reference', 'reference_number']);

            return redirect()->route('reference.number.page')
                ->with('error', 'Reference number already used.');
        }

        $categories = DB::table('categories')
            ->where('is_rice_menu', 0)
            ->get();

        $currentCategory = DB::table('categories')
            ->where('id', $category_id)
            ->first();

        $menus = DB::table('menus')
            ->leftJoin('categories', 'menus.category_id', '=', 'categories.id')
            ->select(
                'menus.id as menu_id',
                'menus.menu_name',
                'menus.menu_pic',
                'menus.menu_price',
                'menus.ingredients',
                'menus.stock_number',
                'menus.status',
                'menus.is_rice_menu',
                'menus.is_add_ons_menu',
                'menus.category_id',
                'categories.category_name'
            )
            ->where('menus.category_id', $category_id)
            ->where('menus.status', 'Available') // ✅ FILTER STATUS
            ->get()
            ->map(function ($menu) {

                if (strpos($menu->menu_name, 'Salsa Strips') !== false) {
                    $menu->required_addon = 'Salsa Strips';
                } elseif (strpos($menu->menu_name, 'Bulgogi Strips') !== false) {
                    $menu->required_addon = 'Bulgogi Strips';
                } else {
                    $menu->required_addon = null;
                }

                return $menu;
            });

        $riceMenus = DB::table('menus')
            ->select(
                'id as menu_id',
                'category_id',
                'menu_pic',
                'menu_name',
                'menu_price',
                'ingredients',
                'stock_number',
                'status',
                'is_rice_menu',
                'is_add_ons_menu',
                'created_at',
                'updated_at'
            )
            ->where('is_rice_menu', 1)
            ->where('status', 'Available') // ✅ FILTER STATUS
            ->get();

        return view('users.menu', compact(
            'menus',
            'categories',
            'category_id',
            'currentCategory',
            'riceMenus'
        ));
    }
}
