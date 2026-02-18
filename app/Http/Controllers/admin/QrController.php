<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QrController extends Controller
{
    public function ShowQrOrder($referenceNumber)
    {
        $orders = DB::table('orders')
            ->leftJoin('menus', 'orders.menu_id', '=', 'menus.id')
            ->leftJoin('menus as rice', 'orders.is_rice_menu', '=', 'rice.id')
            ->leftJoin('menus as addon', 'orders.is_add_ons_menu', '=', 'addon.id')
            ->where('orders.reference_number', $referenceNumber)
            ->select(
                'orders.*',
                'menus.menu_name as menu_name',
                'rice.menu_name as rice_name',
                'addon.menu_name as addon_name'
            )
            ->get();

        if ($orders->isEmpty()) {
            return redirect()->back()->with('error', 'No orders found for this QR.');
        }

        return view('admin.qr_order_show', compact('orders', 'referenceNumber'));
    }
}
