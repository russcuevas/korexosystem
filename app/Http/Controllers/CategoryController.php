<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Make sure you import the model
use App\Models\Ticket;

class CategoryController extends Controller
{
    public function CategoryPage()
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

        // Get all categories except rice and add-ons
        $categories = Category::where('is_rice_menu', 0)
            ->where('is_add_ons_menu', 0)
            ->get();

        return view('users.category', compact('categories'));
    }
}
