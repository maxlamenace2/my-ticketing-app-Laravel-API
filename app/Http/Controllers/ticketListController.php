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

    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'   => 'required|integer|exists:projects,id',
            'title'        => 'required|string|max:255',
            'status'       => 'required|string',        
            'priority'     => 'nullable|string',         
            'billing_type' => 'nullable|string',         
            'time_spent'   => 'nullable|string',         
            'description'  => 'nullable|string',         
            'assigned_to'  => 'nullable|string',    
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',     
        ]);

        $project = Project::findOrFail($validated['project_id']);
        if (Auth::id() != $project->user_id) {
            abort(403, 'Non autorisé.');
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
            'start_date'   => $validated['start_date'],
            'end_date'     => $validated['end_date'],
        ]);

        return redirect()->back()->with('success', 'Nouveau ticket créé avec succès !');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        if (Auth::id() != $ticket->project->user_id) {
            abort(403, 'Non autorisé.');
        }
        
        $ticket->delete();
        
        return redirect()->back()->with('success', 'Ticket supprimé avec succès.');
    }

}