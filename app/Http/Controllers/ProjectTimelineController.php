<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Http\Request;

class ProjectTimelineController extends Controller
{
    //create
    public function create(Organisation $organisation, Project $project)
    {
        return view('organisation.project_timelines.create', compact('organisation', 'project'));
    }

    public function store(Request $request, Organisation $organisation, Project $project)
    {
        // Validate the form data
        $validate = $request->validate([
            'stage' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'project_status_id' => 'required|exists:project_statuses,id',
        ]);


        // Ensure the project belongs to the organisation
        if ($project->organisation_id !== $organisation->id) {
            abort(403, "Unauthorized action.");
        }

        // Create a new project timeline
        $project->timelines()->create($validate);

        // Redirect back with success message
        return redirect()->route('organisation.projects.show', [$organisation->slug, $project->slug])
            ->with('success', 'Project timeline added successfully.');
    }


}
