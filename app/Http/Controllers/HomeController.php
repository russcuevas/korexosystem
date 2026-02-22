<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    #ROUTE : /home - GET METHOD
    public function HomePage()
    {
        // Check if session exists
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

        $category = Category::where('is_rice_menu', '!=', 1)
            ->where('is_add_ons_menu', '!=', 1)
            ->limit(3)
            ->get();

        return view('users.home', compact('category'));
    }
}
