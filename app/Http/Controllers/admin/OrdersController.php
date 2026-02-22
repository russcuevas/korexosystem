<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
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

            $status = $items->first()->status ?? 'Placed order';

            $orders[] = [
                'reference_number' => $ref,
                'status' => $status,
                'items' => $items,
            ];
        }

        return view('admin.orders', compact('orders'));
    }

    public function fetchOrders()
    {
        $referenceNumbers = DB::table('orders')
            ->select('reference_number')
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

            $status = $items->first()->status ?? 'Placed order';

            $orders[] = [
                'reference_number' => $ref,
                'status' => $status,
                'items' => $items,
            ];
        }

        return view('admin.partials.orders_list', compact('orders'))->render();
    }


    public function search(Request $request)
    {
        $query = $request->q;

        $referenceNumbers = DB::table('orders')
            ->select('reference_number')
            ->when($query, function ($q2) use ($query) {
                $q2->where('reference_number', 'like', "{$query}%");
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

            $orders[] = [
                'reference_number' => $ref,
                'status' => $items->first()->status ?? 'Placed order',
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

        $lineWidth = 32; // 58mm printer
        $output = "";

        // ===== HEADER =====
        $output .= str_pad("KOREXO", $lineWidth, " ", STR_PAD_BOTH) . "\n";
        $output .= str_pad("Receipt #$ref", $lineWidth, " ", STR_PAD_BOTH) . "\n";
        $output .= str_pad(date('Y-m-d H:i'), $lineWidth, " ", STR_PAD_BOTH) . "\n";
        $output .= str_repeat("-", $lineWidth) . "\n";

        $total = 0;

        foreach ($items as $item) {

            $name = $item->quantity . "x " . $item->menu_name;
            $price = $item->price;
            $total += $price;

            $priceText = "P" . number_format($price, 2);

            // Available width for name (32 - price width)
            $nameWidth = $lineWidth - strlen($priceText);

            // Word wrap instead of cut
            $wrappedName = wordwrap($name, $nameWidth, "\n", true);
            $nameLines = explode("\n", $wrappedName);

            foreach ($nameLines as $index => $line) {

                if ($index == 0) {
                    // First line has price
                    $output .= str_pad($line, $nameWidth);
                    $output .= $priceText . "\n";
                } else {
                    // Next lines no price
                    $output .= $line . "\n";
                }
            }

            if ($item->rice_name) {
                $output .= "  w/ {$item->rice_name}\n";
            }

            if (!is_null($item->is_add_ons_menu)) {
                $output .= "  [Add-on]\n";
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

        // 1️⃣ Mark the clicked item as served
        $item = DB::table('orders')->where('id', $itemId)->first();

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        DB::table('orders')
            ->where('id', $itemId)
            ->update(['is_served' => 1]);

        $remaining = DB::table('orders')
            ->where('reference_number', $item->reference_number)
            ->where('is_served', 0)
            ->count();

        if ($remaining == 0) {
            DB::table('orders')
                ->where('reference_number', $item->reference_number)
                ->update(['status' => 'Served']);

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

        $updated = DB::table('orders')
            ->where('reference_number', $ref)
            ->update([
                'is_served' => 1,
                'status' => 'Served'
            ]);

        return response()->json([
            'success' => true
        ]);
    }
}
