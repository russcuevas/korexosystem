<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\ErrorCorrectionLevel;
use App\Mail\OrderConfirmationMail;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'reservation_id' => 'required|exists:reservations,id'
        ]);

        $email = $request->email;
        $reservationId = $request->reservation_id;
        $referenceNumber = session('reference_number');

        if (!$referenceNumber) {
            return redirect()->route('cart.page')
                ->with('error', 'No cart found for checkout.');
        }

        $cartItems = DB::table('carts')
            ->where('reference_number', $referenceNumber)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.page')
                ->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {

            // 🔒 Lock reservation
            $reservation = DB::table('reservations')
                ->where('id', $reservationId)
                ->lockForUpdate()
                ->first();

            if (!$reservation) {
                DB::rollBack();
                return redirect()->route('cart.page')
                    ->with('error', 'Invalid reservation slot.');
            }

            if ($reservation->available_slots <= 0) {
                DB::rollBack();
                return redirect()->route('cart.page')
                    ->with('error', 'This time slot is fully booked.');
            }

            $reservedDateTime = Carbon::createFromFormat(
                'Y-m-d h:i A',
                now()->format('Y-m-d') . ' ' . $reservation->time_slot
            )->format('Y-m-d H:i:s');

            $totalAmount = 0;

            foreach ($cartItems as $item) {

                // 🔒 Lock main menu
                $menu = DB::table('menus')
                    ->where('id', $item->menu_id)
                    ->lockForUpdate()
                    ->first();

                if (!$menu || $menu->stock_number < $item->quantity) {
                    DB::rollBack();
                    $menuName = $menu->menu_name ?? 'This item';
                    return redirect()->route('cart.page')
                        ->with('error', $menuName . ' is out of stock or not enough stock available.');
                }

                // 🔒 Lock rice menu
                if ($item->is_rice_menu) {
                    $riceMenu = DB::table('menus')
                        ->where('id', $item->is_rice_menu)
                        ->lockForUpdate()
                        ->first();

                    if (!$riceMenu || $riceMenu->stock_number < $item->quantity) {
                        DB::rollBack();
                        $riceName = $riceMenu->menu_name ?? 'Rice';
                        return redirect()->route('cart.page')
                            ->with('error', $riceName . ' is out of stock.');
                    }
                }

                // 🔒 Lock add-on menu
                if ($item->is_add_ons_menu) {
                    $addonMenu = DB::table('menus')
                        ->where('id', $item->is_add_ons_menu)
                        ->lockForUpdate()
                        ->first();

                    if (!$addonMenu || $addonMenu->stock_number < $item->quantity) {
                        DB::rollBack();
                        $addonName = $addonMenu->menu_name ?? 'Add-on';
                        return redirect()->route('cart.page')
                            ->with('error', $addonName . ' is out of stock.');
                    }
                }

                // ✅ Insert order
                $totalAmount += ($item->quantity * $item->price);

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

                // MAIN MENU
                DB::table('menus')
                    ->where('id', $item->menu_id)
                    ->decrement('stock_number', $item->quantity);

                DB::table('menus')
                    ->where('id', $item->menu_id)
                    ->where('stock_number', '<=', 0)
                    ->update(['status' => 'not available']);

                // RICE MENU
                if ($item->is_rice_menu) {
                    DB::table('menus')
                        ->where('id', $item->is_rice_menu)
                        ->decrement('stock_number', $item->quantity);

                    DB::table('menus')
                        ->where('id', $item->is_rice_menu)
                        ->where('stock_number', '<=', 0)
                        ->update(['status' => 'not available']);
                }

                // ADD-ON MENU
                if ($item->is_add_ons_menu) {
                    DB::table('menus')
                        ->where('id', $item->is_add_ons_menu)
                        ->decrement('stock_number', $item->quantity);

                    DB::table('menus')
                        ->where('id', $item->is_add_ons_menu)
                        ->where('stock_number', '<=', 0)
                        ->update(['status' => 'not available']);
                }
            }

            DB::table('reservations')
                ->where('id', $reservationId)
                ->decrement('available_slots', 1);

            $orders = DB::table('orders')
                ->leftJoin('menus', 'orders.menu_id', '=', 'menus.id')
                ->leftJoin('menus as rice', 'orders.is_rice_menu', '=', 'rice.id')
                ->leftJoin('menus as addon', 'orders.is_add_ons_menu', '=', 'addon.id')
                ->where('orders.reference_number', $referenceNumber)
                ->where('orders.email', $email)
                ->select(
                    'orders.*',
                    'menus.menu_name as menu_name',
                    'rice.menu_name as rice_name',
                    'addon.menu_name as addon_name'
                )
                ->get();

            DB::table('carts')
                ->where('reference_number', $referenceNumber)
                ->delete();

            DB::commit();

            DB::table('tickets')
                ->where('reference_number', $referenceNumber)
                ->where('is_used', 0)
                ->update([
                    'is_used' => 1,
                    'updated_at' => now(),
                ]);

            // ------------------------------
            // GENERATE QR CODE
            // ------------------------------
            $qrFolder = public_path('qr-codes');
            if (!file_exists($qrFolder)) {
                mkdir($qrFolder, 0755, true);
            }

            $qrFileName = $referenceNumber . '.png'; // Back to PNG!
            $qrUrl = route('admin.qr.show', $referenceNumber);

            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($qrUrl)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                ->build();

            // Save the file
            $result->saveToFile($qrFolder . '/' . $qrFileName);

            // ------------------------------
            // SEND EMAIL
            // ------------------------------
            Mail::to($email)->send(
                new OrderConfirmationMail(
                    $orders,
                    $reservedDateTime,
                    $referenceNumber,
                    $totalAmount,
                    $qrFileName
                )
            );

            return redirect()->route('purchase.success', [
                'reference_number' => $referenceNumber
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('cart.page')
                ->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function PurchaseSuccessPage($reference_number)
    {
        $ticket = DB::table('tickets')
            ->where('reference_number', $reference_number)
            ->where('is_used', 1)
            ->first();

        if (!$ticket) {
            return redirect()->route('home.page')
                ->with('error', 'Invalid purchase reference.');
        }

        return view('users.purchase_success', compact('reference_number'));
    }
}
