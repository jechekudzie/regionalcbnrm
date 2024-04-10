<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    //index method
    public function index(Organisation $organisation)
    {
        $projects = $organisation->projects;
        $projectStatuses = ProjectStatus::all();
        $projectCategories = ProjectCategory::all();
        return view('organisation.projects.index', compact('projects', 'organisation', 'projectStatuses', 'projectCategories'));
    }

    //create
    public function create(Organisation $organisation)
    {
        $projectStatuses = ProjectStatus::all();
        $projectCategories = ProjectCategory::all();
        return view('organisation.projects.create', compact('organisation', 'projectStatuses', 'projectCategories'));
    }


    public function store(Request $request, Organisation $organisation)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'project_category_id' => 'required|exists:project_categories,id',
            'project_status_id' => 'required|exists:project_statuses,id',
            'project_description' => 'nullable|string',
            'project_goals' => 'nullable|string',
            'project_funds' => 'nullable|string',
            'project_start_date' => 'nullable|date',
            'project_end_date' => 'nullable|date|after_or_equal:project_start_date',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        // Begin a transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Create the project
           $project =  $organisation->projects()->create([
                'name' => $request->name,
                'project_category_id' => $request->project_category_id,
                'project_status_id' => $request->project_status_id,
                'project_description' => $request->project_description,
                'project_goals' => $request->project_goals,
                'project_funds' => $request->project_funds,
                'project_start_date' => $request->project_start_date,
                'project_end_date' => $request->project_end_date,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            // Commit the transaction
            DB::commit();

            // Redirect to a specified route with a success message
            return redirect()->route('organisation.projects.index', $organisation->slug)->with('success', 'Project created successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();

            // Redirect back with an error message
            return back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    //update method
    public function update(Request $request, Organisation $organisation, Project $project)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'project_category_id' => 'required|exists:project_categories,id',
            'project_status_id' => 'required|exists:project_statuses,id',
            'project_description' => 'nullable|string',
            'project_goals' => 'nullable|string',
            'project_funds' => 'nullable|string',
            'project_start_date' => 'nullable|date',
            'project_end_date' => 'nullable|date|after_or_equal:project_start_date',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        // Begin a transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Update the project
            $project->update([
                'name' => $request->name,
                'project_category_id' => $request->project_category_id,
                'project_status_id' => $request->project_status_id,
                'project_description' => $request->project_description,
                'project_goals' => $request->project_goals,
                'project_funds' => $request->project_funds,
                'project_start_date' => $request->project_start_date,
                'project_end_date' => $request->project_end_date,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            // Commit the transaction
            DB::commit();

            // Redirect to a specified route with a success message
            return redirect()->route('organisation.projects.index', $organisation->slug)->with('success', 'Project updated successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();

            // Redirect back with an error message
            return back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    //show
    public function show(Organisation $organisation, Project $project)
    {
        return view('organisation.projects.show', compact('organisation', 'project'));
    }
}
