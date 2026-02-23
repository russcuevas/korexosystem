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

        // Define coffee menus and their sizes & prices
        $coffeeMenus = [
            'Spanish Latte' => [
                ['size' => 'HOT 12oz', 'price' => 70],
                ['size' => 'COLD 16oz', 'price' => 80],
            ],
            'Americano' => [
                ['size' => 'HOT 12oz', 'price' => 60],
                ['size' => 'COLD 16oz', 'price' => 70],
            ],
            'Cappuccino' => [
                ['size' => 'HOT 12oz', 'price' => 70],
                ['size' => 'COLD 16oz', 'price' => 80],
            ],
        ];

        $price = $menu->menu_price; // default price
        $size = null;

        // Check if menu is coffee and drink_size exists
        $isCoffeeMenu = array_key_exists($menu->menu_name, $coffeeMenus);

        if ($request->drink_size) {
            [$size, $price] = explode('|', $request->drink_size);
            $size = trim($size);
            $price = floatval($price);
        }

        // Query existing cart item with same menu, size, and flags
        $existingItemQuery = Carts::where('reference_number', $referenceNumber)
            ->where('menu_id', $request->menu_id)
            ->where('is_rice_menu', $request->is_rice_menu ?: null)
            ->where('is_add_ons_menu', $request->is_add_ons_menu ?: null);

        if ($size) {
            $existingItemQuery->where('size', $size);
        } else {
            $existingItemQuery->whereNull('size');
        }

        $existingItem = $existingItemQuery->first();

        if ($existingItem) {
            if ($isCoffeeMenu) {
                // For coffee menus, increment quantity and update price if needed
                $existingItem->quantity += 1;
                $existingItem->price = $price; // update price if size changed
                $existingItem->save();

                return back()->with('success', 'Quantity updated for your coffee order!');
            } else {
                // For other menus, limit to 1 and show error
                return back()->with('error', 'You already have this menu in your cart.');
            }
        }

        // If no existing item, create new cart entry
        Carts::create([
            'reference_number' => $referenceNumber,
            'menu_id' => $request->menu_id,
            'is_rice_menu' => $request->is_rice_menu ?: null,
            'is_add_ons_menu' => $request->is_add_ons_menu ?: null,
            'quantity' => 1,
            'price' => $price,
            'size' => $size,
        ]);

        return back()->with('success', 'Item has been added to your cart!');
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

        $cartItems = DB::table('carts')
            ->leftJoin('menus', 'carts.menu_id', '=', 'menus.id')
            ->leftJoin('menus as rice', 'carts.is_rice_menu', '=', 'rice.id')
            ->select(
                'carts.*',
                'menus.menu_name as menu_name',
                'menus.menu_price as menu_price',
                'menus.menu_pic as menu_pic', // <-- add this
                'rice.menu_name as rice_name'
            )
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
