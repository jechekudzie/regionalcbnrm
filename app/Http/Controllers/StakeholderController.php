<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\Project;
use App\Models\Stakeholder;
use Illuminate\Http\Request;

class StakeholderController extends Controller
{
    //create
    public function create(Organisation $organisation, Project $project)
    {
        return view('organisation.project_stakeholders.create', compact('organisation', 'project'));
    }

    public function store(Request $request, Organisation $organisation, Project $project)
    {
        $validated = $request->validate([
            'stakeholder_name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'stakeholder_email' => 'nullable|email|max:255',
            'stakeholder_phone' => 'nullable|string|max:255',
            'stakeholder_address' => 'nullable|string|max:255',
            'interest' => 'nullable|string|max:255',
        ]);

        // Create the Stakeholder
       $project->stakeholders()->create($validated);

        // Redirect back with a success message
        return redirect()->route('organisation.projects.show', [$organisation->slug, $project->slug])
            ->with('success', 'Stakeholder added successfully.');
    }

}
