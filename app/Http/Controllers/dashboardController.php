<?php

namespace App\Http\Controllers;
use App\Models\Ticket; 
use App\Models\Project; 
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        $tickets = Ticket::where('user_id', $userId)->get();
        $projects = Project::where('user_id', $userId)->take(6)->get();
        $TicketRecents = Ticket::where('user_id', $userId)->orderBy('created_at', 'desc')->take(3)->get();
        return view('dashboard', compact('tickets', 'projects', 'TicketRecents'));
    }
}