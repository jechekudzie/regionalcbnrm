<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\PoachingIncident;
use Illuminate\Http\Request;

class PoachingIncidentController extends Controller
{
    //index
    public function index(Organisation $organisation)
    {
        $poachingIncidents = $organisation->poachingIncidents()->get();
        return view('organisation.poaching.index', compact('organisation','poachingIncidents'));
    }

    //store
    public function store(Request $request, Organisation $organisation)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|date_format:Y',
            'date' => 'required|date',
            'time' => 'nullable|date_format:H:i', // Assuming time is stored as a string, adjust format as necessary
            'latitude' => 'nullable',
            'longitude' => 'nullable',

        ]);

        $organisation->poachingIncidents()->create($validated);

        return redirect()->route('organisation.poaching-incidents.index', $organisation->slug);
    }


    //create an update method
    public function update(Request $request, Organisation $organisation, PoachingIncident $poachingIncident)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|date_format:Y',
            'date' => 'required|date',
            'time' => 'nullable', // Assuming time is stored as a string, adjust format as necessary
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'location' => 'nullable|string',
        ]);

        $poachingIncident->update($validated);

        return redirect()->route('organisation.poaching-incidents.index', $organisation->slug);
    }

}
