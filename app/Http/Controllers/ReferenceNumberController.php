<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class ReferenceNumberController extends Controller
{
    #ROUTE: /reference-number - GET METHOD
    public function ReferenceNumberPage()
    {
        return view('users.reference_number');
    }

    #ROUTE: /check-ticket - POST METHOD
    public function CheckTicket(Request $request){
        $request->validate([
            'reference_number' => 'required',
        ]);

        $ticket = Ticket::where('reference_number', $request->reference_number)->first();

        if (!$ticket) {
            return back()->with('error', 'Reference number not found.');
        }

        if ($ticket->is_used == true) {
            return back()->with('error', 'Reference number has already been used.');
        } 

        return redirect()->route('home.page')->with('success', 'Welcome!');    
    }
}
