<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;   

class projectListController extends Controller
{
    public function projectsList()
    {
        $userId = Auth::id();
        $projects = Project::where('user_id', $userId)->get();
        return view('projects-list', compact('projects'));    
    }

    
    public function destroyApiProject($id)
    {
        $project = Project::findOrFail($id);
        
        if(Auth::id() != $project->user_id) {
             return response()->json(['message' => 'Non autorisé.'], 403); 
        }
        
        $project->delete();
        return response()->json(['message' => 'Projet supprimé avec succès.']);
    }

    
    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'project-name'    => ['required', 'string', 'max:255'],
            'project-client'  => ['nullable', 'string', 'max:255'],
            'project-details' => ['nullable', 'string'],
            'collaborators'   => ['nullable', 'string', 'max:255'],
        ]);

        $project = Project::create([
            'user_id'       => Auth::id(), 
            'ProjectName'   => $validated['project-name'],
            'Client'        => $validated['project-client'],
            'Description'   => $validated['project-details'],
            'Collaborateur' => $validated['collaborators'],
        ]);

        return response()->json([
            'message' => 'Projet ajouté avec succès.',
            'project' => [
                'id'            => $project->id,
                'ProjectName'   => $project->ProjectName,
                'Client'        => $project->Client,
                'Description'   => $project->Description,
                'Collaborateur' => $project->Collaborateur,
                'show_url'      => route('project-detail', $project->id),
                'destroy_url'   => route('api.projects.destroy' , $project->id),
            ],
        ], 201);
    }


}