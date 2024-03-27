<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\Poacher;
use App\Models\PoachingIncident;
use Illuminate\Http\Request;

class PoacherController extends Controller
{
    //

    public function index(Organisation $organisation, PoachingIncident $poachingIncident)
    {

        return view('organisation.poaching.add_incident_poachers', compact('organisation', 'poachingIncident'));

    }

    public function store(Request $request,Organisation $organisation, PoachingIncident $poachingIncident)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'poacher_type_id' => 'required|exists:poacher_types,id',
            'offence_type_id' => 'required|exists:offence_types,id',
            'poaching_reason_id' => 'required|exists:poaching_reasons,id',
            'full_name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender_id' => 'nullable|exists:genders,id',
            'identification_type_id' => 'nullable|exists:identification_types,id',
            'identification' => 'nullable|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'province_id' => 'nullable|exists:provinces,id',
            'docket_number' => 'nullable|string|max:255',
        ]);

        // Create a new Poacher record in the database
        $poacher = $poachingIncident->poachers()->create($validatedData);


        // Redirect back or to another page with a success message
        return redirect()->route('organisation.poaching-incident-poacher.index',[$organisation->slug,$poachingIncident->slug])->with('success', 'Poacher added successfully.');

    }


}
