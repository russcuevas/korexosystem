<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use Illuminate\Http\Request;

class CartCountsController extends Controller
{
    public function FetchCartCountAjax()
    {
        $cartCount = 0;

        if (session('verified_reference')) {
            $ref = session('reference_number');
            $cartCount = \App\Models\Carts::where('reference_number', $ref)->sum('quantity');
        }

        return response()->json(['count' => $cartCount]);
    }
}
