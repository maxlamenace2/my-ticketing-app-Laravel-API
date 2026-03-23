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

    public function projectsListCreate(Request $request)
    {
        $validated = $request->validate([
            'project-name' => 'required|string|max:255',
            'project-client' => 'nullable|string|max:255', 
            'project-details' => 'required|string',
            'collaborators' => 'required|string|max:255',
        ]);

        
        Project::create([
            'user_id' => Auth::id(), 
            'ProjectName' => $validated['project-name'],
            'Client' => $validated['project-client'],
            'Description' => $validated['project-details'],
            'Collaborateur' => $validated['collaborators'],
        ]);

        return redirect()->route('projects-list');
    }

    public function projectsListDelete(Request $request)
    {
        
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:projects,id'], 
        ]);

        $project = Project::findOrFail($validated['id']);

    
        if(auth()->id() != $project->user_id) {
             abort(403, 'Unauthorized action.'); 
        }
        
        $project->delete();
        return redirect()->route('projects-list');
    }
}