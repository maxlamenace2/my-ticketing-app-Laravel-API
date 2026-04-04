<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class projectDetailController extends Controller
{
    public function projectDetail($id,Request $request)
    {
        $project = Project::findOrFail($id);
        
        if (Auth::id() !== $project->user_id) {
            abort(403, 'Vous n\'êtes pas autorisé à voir ce projet.');
        }
    
        $userId = Auth::id();
        $query = Ticket::where('project_id', $project->id);
        $filter = $request->query('filter');

        if ($filter && $filter !== 'All') {
            $query->where('priority', strtolower($filter));
        }

        $tickets = $query->get();

        return view('project-detail', compact('project', 'tickets'));
    }
    
    public function updateApiProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if (Auth::id() != $project->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
            'project_name'        => ['required', 'string', 'max:255'],
            'project_description' => ['nullable', 'string'],
            'collaborateurs'      => ['nullable', 'string', 'max:255'],
            'hours_spent'         => ['nullable', 'numeric'], 
            'hours_budget'        => ['nullable', 'numeric'], 
        ]);

        $project->update([
            'ProjectName'     => $validated['project_name'],
            'Description'     => $validated['project_description'],
            'Collaborateur'   => $validated['collaborateurs'],
            'spent_hours'     => $validated['hours_spent'] ?? 0,    
            'allocated_hours' => $validated['hours_budget'] ?? 0,  
        ]);

        return response()->json([
            'message' => 'Projet mis à jour avec succès !',
            'project' => $project
        ]);
    }

    /*public function createTicket(Request $request)
    {
        $validated = $request->validate([
            'project_id'      => 'required|integer|exists:projects,id',
            'project-name'    => 'required|string|max:255', 
            'ticket-status'   => 'required|string',
            'ticket-priority' => 'nullable|string',
            'ticket-type'     => 'nullable|string',
            'real-time'       => 'nullable|string',
            'project-details' => 'nullable|string', 
            'assigned_to'     => 'nullable|string',
        ]);

        $project = Project::findOrFail($validated['project_id']);
        if (Auth::id() !== $project->user_id) {
            abort(403, 'Action non autorisée.');
        }

        Ticket::create([
            'project_id'   => $validated['project_id'],
            'user_id'      => Auth::id(),
            'title'        => $validated['project-name'],
            'description'  => $validated['project-details'],
            'status'       => $validated['ticket-status'],
            'priority'     => $validated['ticket-priority'],
            'billing_type' => $validated['ticket-type'],
            'time_spent'   => $validated['real-time'],
            'assigned_to'  => $validated['assigned_to'],
        ]);

        return back()->with('success', 'Le ticket a été ajouté au projet !');
    }

    public function destroyApiTicketP($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        if (Auth::id() != $ticket->project->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }
        
        $ticket->delete();
        return response()->json(['message' => 'Ticket supprimé avec succès.']);
    }*/
}