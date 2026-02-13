<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketingController extends Controller
{
    #ROUTE: /admin/ticketing - GET METHOD
    public function AdminTicketingPage()
    {
        $tickets = Ticket::all();
        return view('admin.ticketing', compact('tickets'));
    }
}
