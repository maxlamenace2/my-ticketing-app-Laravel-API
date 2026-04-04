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

    public function storeApi(Request $request)
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
        ]);

        $project = Project::findOrFail($validated['project_id']);
        if (Auth::id() != $project->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $ticket = Ticket::create([
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


        return response()->json([
            'message' => 'Nouveau ticket créé avec succès !',
            'ticket' => [
                'id'           => $ticket->id,
                'title'        => $ticket->title,
                'status'       => $ticket->status,
                'priority'     => $ticket->priority,
                'assigned_to'  => $ticket->assigned_to,
                'projectName'  => $project->ProjectName, 

                'show_url'     => route('ticket-detail', $ticket->id),
                'destroy_url'  => route('api.tickets.destroy', $ticket->id),
            ],
        ], 201);
    }


    public function destroyApiTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        if (Auth::id() != $ticket->project->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }
        
        $ticket->delete();
        return response()->json(['message' => 'Ticket supprimé avec succès.']);
    }
}