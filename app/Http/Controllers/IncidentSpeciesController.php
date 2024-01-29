<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Organisation;
use App\Models\Species;
use Illuminate\Http\Request;

class IncidentSpeciesController extends Controller
{
    //
    public function index(Organisation $organisation, Incident $incident)
    {
        $incidentSpecies = $incident->species()->get();
        $speciesList = Species::all();
        return view('organisation.incidents.add_incident_species', compact('speciesList','incidentSpecies', 'incident', 'organisation'));
    }

    public function store(Request $request, Organisation $organisation, Incident $incident)
    {

        // Validate the request
        $validated = $request->validate([
            'species' => 'required|array',
            'species.*' => 'exists:species,id', // Ensure each species ID exists in the database
        ]);

        $incident->species()->sync($validated['species']); // Where $validated['species'] is an array of species IDs.

        // Redirect back with a success message
        return redirect()->route('organisation.incident-species.index', [$organisation->slug,$incident->slug])->with('success', 'Species added to incident successfully.');
    }

    public function destroy(Organisation $organisation, Incident $incident, $incidentSpecies)
    {

        $incident->species()->detach($incidentSpecies);
        return redirect()->route('organisation.incident-species.index', [$organisation->slug,$incident->slug])->with('success', 'Species removed from incident successfully.');
    }

}
