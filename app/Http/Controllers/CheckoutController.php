<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // ✅ Validate inputs
        $request->validate([
            'email' => 'required|email',
            'reservation_id' => 'required|exists:reservations,id'
        ]);

        $email = $request->email;
        $reservationId = $request->reservation_id;

        // ✅ Get reference number from session
        $referenceNumber = session('reference_number');

        if (!$referenceNumber) {
            return redirect()->back()->with('error', 'No cart found for checkout.');
        }

        // ✅ Get cart items
        $cartItems = DB::table('carts')
            ->where('reference_number', $referenceNumber)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {

            // 🔒 Lock reservation row to prevent overbooking
            $reservation = DB::table('reservations')
                ->where('id', $reservationId)
                ->lockForUpdate()
                ->first();

            if (!$reservation) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Invalid reservation slot.');
            }

            if ($reservation->available_slots <= 0) {
                DB::rollBack();
                return redirect()->back()->with('error', 'This time slot is fully booked.');
            }

            // ✅ Convert AM/PM time to MySQL datetime format
            $reservedDateTime = Carbon::createFromFormat(
                'Y-m-d h:i A',
                now()->format('Y-m-d') . ' ' . $reservation->time_slot
            )->format('Y-m-d H:i:s');

            foreach ($cartItems as $item) {

                // ✅ Insert into orders table
                DB::table('orders')->insert([
                    'reference_number' => $item->reference_number,
                    'email'            => $email,
                    'menu_id'          => $item->menu_id,
                    'is_rice_menu'     => $item->is_rice_menu,
                    'is_add_ons_menu'  => $item->is_add_ons_menu,
                    'quantity'         => $item->quantity,
                    'price'            => $item->price,
                    'status'           => 'Placed order',
                    'reserved_at'      => $reservedDateTime,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                // ✅ Deduct main menu stock
                DB::table('menus')
                    ->where('id', $item->menu_id)
                    ->decrement('stock_number', $item->quantity);

                // ✅ Deduct rice stock
                if ($item->is_rice_menu) {
                    DB::table('menus')
                        ->where('id', $item->is_rice_menu)
                        ->decrement('stock_number', $item->quantity);
                }

                // ✅ Deduct add-ons stock
                if ($item->is_add_ons_menu) {
                    DB::table('menus')
                        ->where('id', $item->is_add_ons_menu)
                        ->decrement('stock_number', $item->quantity);
                }
            }

            // ✅ Deduct reservation slot
            DB::table('reservations')
                ->where('id', $reservationId)
                ->decrement('available_slots', 1);

            // ✅ Clear cart
            DB::table('carts')
                ->where('reference_number', $referenceNumber)
                ->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Checkout successful! Reservation confirmed.');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with(
                'error',
                'Checkout failed: ' . $e->getMessage()
            );
        }
    }
}
