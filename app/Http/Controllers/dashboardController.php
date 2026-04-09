<?php

namespace App\Http\Controllers;

use App\Models\Ticket; 
use App\Models\Project; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

class dashboardController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        
        $tickets = Ticket::where('user_id', $userId)->get();
        $projects = Project::where('user_id', $userId)->take(6)->get();
        $TicketRecents = Ticket::where('user_id', $userId)->orderBy('created_at', 'desc')->take(3)->get();

        $newTicketsToday = Ticket::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $closedTicketsToday = Ticket::where('user_id', $userId)
            ->whereIn('status', ['Closed', 'Terminé', 'Validé']) 
            ->whereDate('updated_at', Carbon::today())
            ->count();

        $pastDueTickets = Ticket::where('user_id', $userId)
            ->whereNotIn('status', ['Closed', 'Terminé', 'Validé'])
            ->whereNotNull('end_date') 
            ->whereDate('end_date', '<', Carbon::today())
            ->count();

        return view('dashboard', compact('tickets', 'projects', 'TicketRecents', 'newTicketsToday', 'closedTicketsToday', 'pastDueTickets'));
    }
}