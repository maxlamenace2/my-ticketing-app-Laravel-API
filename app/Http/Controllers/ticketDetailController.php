<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ticketDetailController extends Controller
{
    public function ticketDetail($id)
    {
        $ticket = Ticket::with('project')->findOrFail($id);

        if (Auth::id() !== $ticket->project->user_id) {
            abort(403, 'Accès refusé.');
        }

        $formattedStartDate = $ticket->start_date ? Carbon::parse($ticket->start_date)->format('d/m/Y') : 'N/A';
        $formattedEndDate   = $ticket->end_date ? Carbon::parse($ticket->end_date)->format('d/m/Y') : 'N/A';
        
        $project = $ticket->project;
        return view('ticket-detail', compact('ticket', 'project', 'formattedStartDate', 'formattedEndDate'));
    }


    public function updateApiTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        if (Auth::id() != $ticket->project->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
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

        $ticket->update($validated);

        return response()->json([
            'message' => 'Ticket mis à jour avec succès !',
            'ticket'  => $ticket
        ]);
    }
}