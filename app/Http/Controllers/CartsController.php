<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carts;
use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class CartsController extends Controller
{
    public function AddToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
        ]);

        $referenceNumber = session('reference_number');

        if (!$referenceNumber) {
            return redirect()->route('reference.number.page')
                ->with('error', 'Please enter a valid reference number first.');
        }

        $menu = DB::table('menus')->where('id', $request->menu_id)->first();

        if (!$menu) {
            return back()->with('error', 'Menu not found.');
        }

        // Check if this category is already in cart
        $existingCategory = Carts::join('menus', 'carts.menu_id', '=', 'menus.id')
            ->where('carts.reference_number', $referenceNumber)
            ->where('menus.category_id', $menu->category_id)
            ->exists();

        if ($existingCategory) {
            return back()->with('error', 'You already ordered an item from this category.');
        }

        Carts::create([
            'reference_number' => $referenceNumber,
            'menu_id' => $request->menu_id,
            'is_rice_menu' => $request->is_rice_menu ?: null,
            'is_add_ons_menu' => $request->is_add_ons_menu ?: null,
            'quantity' => 1,
            'price' => $menu->menu_price,
        ]);

        return back()->with('success',  'Item has been added to your cart!');
    }


    public function CartPage()
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

        $referenceNumber = session('reference_number');

        if (!$referenceNumber) {
            return redirect()->route('reference.number.page')
                ->with('error', 'Please enter a valid reference number first.');
        }

        $cartItems = Carts::select(
            'carts.*',
            'menus.menu_name as menu_name',
            'menus.menu_price as menu_price',
            'rice.menu_name as rice_name'
        )
            ->join('menus', 'carts.menu_id', '=', 'menus.id')
            ->leftJoin('menus as rice', 'carts.is_rice_menu', '=', 'rice.id')
            ->where('carts.reference_number', $referenceNumber)
            ->get();

        $reservations = Reservation::where('available_slots', '>', 0)->get();

        return view('users.carts', compact('cartItems', 'reservations'));
    }

    public function DeleteCartItem($id)
    {
        $referenceNumber = session('reference_number');

        if (!$referenceNumber) {
            return redirect()->route('reference.number.page')
                ->with('error', 'Session expired.');
        }

        $cartItem = Carts::where('id', $id)
            ->where('reference_number', $referenceNumber)
            ->first();

        if (!$cartItem) {
            return back()->with('error', 'Cart item not found.');
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
