<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; 
use Illuminate\Support\Facades\Auth;

class ticketDetailController extends Controller
{
    public function ticketDetail($id)
    {
        $ticket = Ticket::with('project')->findOrFail($id);

        if (Auth::id() !== $ticket->project->user_id) {
            abort(403, 'Accès refusé.');
        }
        

        $project = $ticket->project;
        return view('ticket-detail', compact('ticket', 'project'));
    }

    public function updateTicket(Request $request)
    {
        $validated = $request->validate([
            'ticket_id'       => 'required|integer|exists:tickets,id',
            'title'           => 'required|string|max:255', 
            'status'          => 'required|string',        
            'priority'        => 'nullable|string',         
            'billing_type'    => 'nullable|string',         
            'time_spent'      => 'nullable|string',         
            'description'     => 'nullable|string',         
            'assigned_to'     => 'nullable|string',         
        ]);
        
        $ticket = Ticket::findOrFail($validated['ticket_id']);
        if (Auth::id() !== $ticket->project->user_id) {
            abort(403, 'Action non autorisée.');
        }
        
        $ticket->update([
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'status'       => $validated['status'],
            'priority'     => $validated['priority'],
            'billing_type' => $validated['billing_type'],
            'time_spent'   => $validated['time_spent'],
            'assigned_to'  => $validated['assigned_to'],
        ]);

        return back()->with('success', 'Le ticket a été mis à jour avec succès !');

    }
}