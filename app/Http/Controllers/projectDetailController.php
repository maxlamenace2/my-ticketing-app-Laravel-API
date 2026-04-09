<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if (Auth::id() != $project->user_id) {
            abort(403, 'Non autorisé.'); 
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

        return redirect()->back()->with('success', 'Projet mis à jour avec succès !');
    }

    public function uploadContract(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if (Auth::id() != $project->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $request->validate([
            'contract_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('contract_file')) {
            $file = $request->file('contract_file');
            
            $originalName = $file->getClientOriginalName();
            
            $filename = time() . '_' . $originalName;  
            $path = $file->storeAs('contracts', $filename, 'public'); // enregistre fichier dans laravel

        
            $project->update([
                'contract_file_path' => $path,
                'contract_file_name' => $originalName 
            ]);

            return response()->json([
                'message'   => 'Contrat uploadé avec succès !',
                'file_name' => $originalName, 
                'file_url'  => asset('storage/' . $path) 
            ]);
        }

        return response()->json(['message' => 'Aucun fichier reçu.'], 400);
    }

    public function deleteContract($id)
    {
        $project = Project::findOrFail($id);

        if (Auth::id() != $project->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        
        if ($project->contract_file_path) {
            
            Storage::disk('public')->delete($project->contract_file_path);

            $project->update([
                'contract_file_path' => null,
                'contract_file_name' => null
            ]);

            return response()->json(['message' => 'Contrat supprimé avec succès.']);
        }

        return response()->json(['message' => 'Aucun contrat à supprimer.'], 400);
    }
}