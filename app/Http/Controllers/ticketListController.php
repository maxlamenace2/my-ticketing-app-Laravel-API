<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; 
use App\Models\Project; 
use Illuminate\Support\Facades\Auth;
class ticketListController extends Controller
{
    public function ticketList(Request $request)
    {
        $userId = Auth::id();
        $query = Ticket::where('user_id', $userId);
        $filter = $request->query('filter');

        if ($filter && $filter !== 'All') {
            $query->where('priority', strtolower($filter));
        }

        $tickets = $query->get();
        $projects = Project::where('user_id', $userId)->get();
        return view('tickets-list', compact('tickets', 'projects'));
    }

    public function ticketListCreate(Request $request)
    {
        $validated = $request->validate([
            'project_id'   => 'required|integer|exists:projects,id',
            'title'        => 'required|string|max:255', # name du html
            'status'       => 'required|string',        
            'priority'     => 'nullable|string',         
            'billing_type' => 'nullable|string',         
            'time_spent'   => 'nullable|string',         
            'description'  => 'nullable|string',         
            'assigned_to'  => 'nullable|string',         
        ]);

        $project = Project::findOrFail($validated['project_id']);
        if (Auth::id() !== $project->user_id) {
            abort(403, 'fail');
        }

        Ticket::create([
            'project_id'   => $validated['project_id'],
            'user_id'      => Auth::id(), 
            
            'title'        => $validated['title'], 
            'description'  => $validated['description'],
            'status'       => $validated['status'],
            'priority'     => $validated['priority'],
            'billing_type' => $validated['billing_type'],
            'time_spent'   => $validated['time_spent'],
            'assigned_to'  => $validated['assigned_to'], 
        ]);

        return redirect()->route('tickets-list')->with('success', 'Nouveau ticket créé avec succès !');
    }


    public function TicketListDelete(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|integer|exists:tickets,id',
        ]);

        $ticket = Ticket::findOrFail($validated['ticket_id']);

        if (Auth::id() !== $ticket->project->user_id) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce ticket.');
        }

        $ticket->delete();

        return back()->with('success', 'Le ticket a été supprimé avec succès !');
    }
}