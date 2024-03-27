<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Organisation;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    //
    public function index(Organisation $organisation)
    {
        $incidents = $organisation->incidents()->get();
        return view('organisation.incidents.index', compact('incidents', 'organisation'));
    }
    public function store(Request $request, Organisation $organisation)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'year' => 'nullable|integer',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',

        ]);


        // Create a new Incident instance and fill the fields
        $incident = new Incident();
        $incident->organisation_id = $organisation->id; // Assuming you have the organisation ID
        $incident->year = $validated['year'];
        $incident->title = $validated['title'];
        $incident->description = $validated['description'];
        $incident->location = $validated['location'];
        $incident->latitude = $validated['latitude'];
        $incident->longitude = $validated['longitude'];
        $incident->date = $validated['date'];
        $incident->time = $validated['time'];

        // Save the incident
        $incident->save();

        // Redirect back or to another page with a success message
        return redirect()->route('organisation.incidents.index',$organisation->slug)->with('success', 'Incident added successfully.');
    }

    //show method
    public function show(Organisation $organisation, Incident $incident)
    {

        dd($incident, $organisation);
        return view('organisation.incidents.index', compact('incident', 'organisation'));
    }

    //update method
    public function update(Request $request, Organisation $organisation, Incident $incident)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'year' => 'nullable|integer',
            'date' => 'nullable|date',
            'time' => 'nullable',

        ]);

        // Update the incident
        $incident->update($validated);

        // Redirect back or to another page with a success message
        return redirect()->route('organisation.incidents.index',$organisation->slug)->with('success', 'Incident updated successfully.');
    }


}
