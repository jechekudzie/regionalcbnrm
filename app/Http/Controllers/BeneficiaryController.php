<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Organisation;
use App\Models\Project;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    //create
    public function create(Organisation $organisation,Project $project)
    {
        return view('organisation.project_beneficiaries.create',compact('organisation','project'));
    }

    public function store(Request $request, Organisation $organisation,Project $project)
    {
        $validate = $request->validate([
            'beneficiary_name' => 'required|string|max:255',
            'beneficiary_number' => 'required|integer',
        ]);

        $beneficiary = $project->beneficiaries()->create($validate);

        return redirect()->route('organisation.projects.show',[$organisation->slug,$project->slug])->with('success', 'Beneficiary added successfully.');
    }

}
