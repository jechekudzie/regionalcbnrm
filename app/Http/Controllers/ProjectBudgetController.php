<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\Project;
use App\Models\ProjectBudget;
use Illuminate\Http\Request;

class ProjectBudgetController extends Controller
{
    //create
    public function create(Organisation $organisation,Project $project,Request $request)
    {
        return view('organisation.project_budgets.create',compact('organisation','project'));
    }

    public function store(Request $request, Organisation $organisation, Project $project)
    {
        $budgetItem = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_description' => 'nullable|string',
            'item_cost' => 'required|numeric|min:0',
            'item_quantity' => 'required|integer|min:1',
            'item_total_cost' => 'required|numeric|min:0',
            'item_status' => 'nullable|string|max:255',
        ]);

        $projectBudget = $project->budgets()->create($budgetItem);


        return redirect()->route('organisation.projects.show', [$organisation->slug, $project->slug])->with('success', 'Budget item added successfully.');
    }

}
