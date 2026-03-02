<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function OrdersPage()
    {
        $referenceNumbers = DB::table('orders')
            ->select('reference_number')
            ->distinct()
            ->orderBy('created_at', 'desc')
            ->get()
            ->pluck('reference_number');

        $orders = [];

        foreach ($referenceNumbers as $ref) {
            $items = DB::table('orders')
                ->select(
                    'orders.*',
                    'menus.menu_name as menu_name',
                    'rice.menu_name as rice_name',
                    'addons.menu_name as addon_name'
                )
                ->join('menus', 'orders.menu_id', '=', 'menus.id')
                ->leftJoin('menus as rice', 'orders.is_rice_menu', '=', 'rice.id')
                ->leftJoin('menus as addons', 'orders.is_add_ons_menu', '=', 'addons.id')
                ->where('orders.reference_number', $ref)
                ->get();

            if ($items->isEmpty()) {
                continue;
            }

            $firstItem = $items->first();

            $orders[] = [
                'reference_number' => $ref,
                'status' => $firstItem->status ?? 'Placed order',
                'fullname' => $firstItem->fullname ?? 'N/A',
                'email' => $firstItem->email ?? 'N/A',
                'reserved_at' => $firstItem->reserved_at ?? null,
                'items' => $items,
            ];
        }

        return view('admin.orders', compact('orders'));
    }

    public function fetchOrders(Request $request)
    {
        $time = $request->query('time'); // e.g., "10:00:00"

        $referenceNumbers = DB::table('orders')
            ->select('reference_number')
            ->when($time, function ($query, $time) {
                $query->whereTime('reserved_at', $time);
            })
            ->distinct()
            ->orderBy('created_at', 'desc')
            ->pluck('reference_number');

        $orders = [];

        foreach ($referenceNumbers as $ref) {
            $items = DB::table('orders')
                ->select(
                    'orders.*',
                    'menus.menu_name as menu_name',
                    'rice.menu_name as rice_name',
                    'addons.menu_name as addon_name'
                )
                ->join('menus', 'orders.menu_id', '=', 'menus.id')
                ->leftJoin('menus as rice', 'orders.is_rice_menu', '=', 'rice.id')
                ->leftJoin('menus as addons', 'orders.is_add_ons_menu', '=', 'addons.id')
                ->where('orders.reference_number', $ref)
                ->get();

            if ($items->isEmpty()) continue;

            $firstItem = $items->first();

            $orders[] = [
                'reference_number' => $ref,
                'status' => $firstItem->status ?? 'Placed order',
                'fullname' => $firstItem->fullname ?? 'N/A',
                'email' => $firstItem->email ?? 'N/A',
                'reserved_at' => $firstItem->reserved_at ?? null,
                'items' => $items,
            ];
        }

        return view('admin.partials.orders_list', compact('orders'))->render();
    }


    public function search(Request $request)
    {
        $query = $request->q;
        $time = $request->time; // optional time filter, e.g., '10:00', '11:00'

        $referenceNumbers = DB::table('orders')
            ->select('reference_number')
            ->when($query, fn($q2) => $q2->where('reference_number', 'like', "{$query}%"))
            ->when($time, fn($q3) => $q3->whereTime('reserved_at', $time))
            ->distinct()
            ->orderBy('created_at', 'desc')
            ->pluck('reference_number');

        $orders = [];

        foreach ($referenceNumbers as $ref) {
            $items = DB::table('orders')
                ->select(
                    'orders.*',
                    'menus.menu_name as menu_name',
                    'rice.menu_name as rice_name',
                    'addons.menu_name as addon_name'
                )
                ->join('menus', 'orders.menu_id', '=', 'menus.id')
                ->leftJoin('menus as rice', 'orders.is_rice_menu', '=', 'rice.id')
                ->leftJoin('menus as addons', 'orders.is_add_ons_menu', '=', 'addons.id')
                ->where('orders.reference_number', $ref)
                ->get();

            if ($items->isEmpty()) continue;

            $firstItem = $items->first();

            $orders[] = [
                'reference_number' => $ref,
                'status' => $firstItem->status ?? 'Placed order',
                'fullname' => $firstItem->fullname ?? 'N/A',
                'email' => $firstItem->email ?? 'N/A',
                'reserved_at' => $firstItem->reserved_at ?? null,
                'items' => $items,
            ];
        }

        return view('admin.partials.orders_list', compact('orders'))->render();
    }

    public function updateStatus(Request $request)
    {
        $ref = $request->reference_number;

        DB::table('orders')
            ->where('reference_number', $ref)
            ->update(['status' => 'Pending']);

        return response()->json(['success' => true]);
    }

    public function printReceipt($ref)
    {
        $items = DB::table('orders')
            ->select(
                'orders.*',
                'menus.menu_name as menu_name',
                'rice.menu_name as rice_name'
            )
            ->join('menus', 'orders.menu_id', '=', 'menus.id')
            ->leftJoin('menus as rice', 'orders.is_rice_menu', '=', 'rice.id')
            ->where('orders.reference_number', $ref)
            ->get();

        if ($items->isEmpty()) {
            return response('Order not found', 404);
        }

        $lineWidth = 32; // 58mm printer width approx
        $output = "";

        // ===== HEADER =====
        $output .= str_pad("KOREXO", $lineWidth, " ", STR_PAD_BOTH) . "\n";
        $output .= str_pad("Receipt #$ref", $lineWidth, " ", STR_PAD_BOTH) . "\n";
        $output .= str_pad(date('Y-m-d H:i'), $lineWidth, " ", STR_PAD_BOTH) . "\n";
        $output .= str_repeat("-", $lineWidth) . "\n";

        $total = 0;

        foreach ($items as $item) {

            // Quantity from DB
            $qty = $item->quantity;
            $lineTotal = $item->price * $qty;
            $total += $lineTotal;

            $sizeText = $item->size ? " " . $item->size : "";

            // MAIN ITEM
            if (!$item->is_add_ons_menu) { // 0 or NULL
                $name = $qty . "x " . $item->menu_name . $sizeText;
            }
            // ADD-ON ITEM
            else {
                $name = $qty . "x " . $item->menu_name . $sizeText . " [Add-on]";
            }

            $priceText = "P" . number_format($lineTotal, 2);
            $nameWidth = $lineWidth - strlen($priceText);
            $wrappedName = wordwrap($name, $nameWidth, "\n", true);
            $nameLines = explode("\n", $wrappedName);

            foreach ($nameLines as $index => $line) {
                if ($index === 0) {
                    $output .= str_pad($line, $nameWidth);
                    $output .= $priceText . "\n";
                } else {
                    $output .= $line . "\n";
                }
            }

            // Rice menu
            if ($item->rice_name && !$item->is_add_ons_menu) {
                $output .= "  w/ {$item->rice_name}\n";
            }
        }

        $output .= str_repeat("-", $lineWidth) . "\n";
        $totalText = "P" . number_format($total, 2);
        $output .= str_pad("TOTAL", $lineWidth - strlen($totalText));
        $output .= $totalText . "\n";
        $output .= str_repeat("-", $lineWidth) . "\n\n";
        $output .= str_pad("Thank you for your order!", $lineWidth, " ", STR_PAD_BOTH) . "\n\n\n";

        return response($output)->header('Content-Type', 'text/plain');
    }

    public function getItems($ref)
    {
        $items = DB::table('orders')
            ->select(
                'orders.*',
                'menus.menu_name as menu_name',
                'rice.menu_name as rice_name'
            )
            ->join('menus', 'orders.menu_id', '=', 'menus.id')
            ->leftJoin('menus as rice', 'orders.is_rice_menu', '=', 'rice.id')
            ->where('orders.reference_number', $ref)
            ->get();

        if ($items->isEmpty()) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json([
            'reference_number' => $ref,
            'items' => $items
        ]);
    }

    public function serveItem(Request $request)
    {
        $itemId = $request->item_id;

        $item = DB::table('orders')->where('id', $itemId)->first();

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        // ✅ Mark item as served
        DB::table('orders')
            ->where('id', $itemId)
            ->update(['is_served' => 1]);

        // ✅ Check remaining unserved items
        $remaining = DB::table('orders')
            ->where('reference_number', $item->reference_number)
            ->where('is_served', 0)
            ->count();

        if ($remaining == 0) {

            // ✅ Update status to Served
            DB::table('orders')
                ->where('reference_number', $item->reference_number)
                ->update(['status' => 'Served']);

            // 🔥 Get all items of this reference
            $orders = DB::table('orders')
                ->where('reference_number', $item->reference_number)
                ->get();

            $basePrice = 490; // fixed ticket price
            $addonsTotal = 0;

            foreach ($orders as $order) {
                // Only count add-ons
                if (!is_null($order->is_add_ons_menu)) {
                    $addonsTotal += ($order->price * $order->quantity);
                }
            }

            $finalTotal = $basePrice + $addonsTotal;

            // ✅ Prevent duplicate sales record
            $existingSale = Sales::where('reference_number', $item->reference_number)->first();

            if (!$existingSale) {
                Sales::create([
                    'reference_number' => $item->reference_number,
                    'total_price' => $finalTotal
                ]);
            }

            return response()->json([
                'success' => true,
                'completed' => true
            ]);
        }

        return response()->json([
            'success' => true,
            'completed' => false
        ]);
    }

    public function completeAll(Request $request)
    {
        $ref = $request->reference_number;

        $orders = DB::table('orders')
            ->where('reference_number', $ref)
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        DB::table('orders')
            ->where('reference_number', $ref)
            ->update([
                'is_served' => 1,
                'status' => 'Served'
            ]);

        $basePrice = 490;
        $addonsTotal = 0;

        foreach ($orders as $order) {
            if (!is_null($order->is_add_ons_menu)) {
                $addonsTotal += ($order->price * $order->quantity);
            }
        }

        $finalTotal = $basePrice + $addonsTotal;
        $existingSale = Sales::where('reference_number', $ref)->first();

        if (!$existingSale) {
            Sales::create([
                'reference_number' => $ref,
                'total_price' => $finalTotal
            ]);
        }

        return response()->json([
            'success' => true,
            'total' => $finalTotal
        ]);
    }
}
