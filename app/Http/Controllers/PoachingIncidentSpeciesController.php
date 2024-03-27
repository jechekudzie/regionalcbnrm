<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Organisation;
use App\Models\PoachingIncident;
use App\Models\Species;
use Illuminate\Http\Request;

class PoachingIncidentSpeciesController extends Controller
{
    //
    public function index(Organisation $organisation, PoachingIncident $poachingIncident)
    {
        $poachingIncidentSpecies = $poachingIncident->species()->get();
        $speciesList = Species::all();
        return view('organisation.poaching.add_incident_species', compact('speciesList', 'poachingIncident', 'poachingIncidentSpecies', 'organisation'));
    }


    public function store(Request $request, Organisation $organisation, PoachingIncident $poachingIncident)
    {

        $validated = $request->validate([
            'species' => 'required|array',
            'species.*' => 'exists:species,id', // Ensure each species ID exists in the database
            'male_count' => 'sometimes|array',
            'female_count' => 'sometimes|array',
        ]);

        foreach ($validated['species'] as $speciesId) {
            $request->validate([
                "male_count.{$speciesId}" => 'required_with:species.*|integer|min:0',
                "female_count.{$speciesId}" => 'required_with:species.*|integer|min:0',
            ]);
        }

        // Prepare data for syncing with additional fields
        $speciesData = [];
        foreach ($validated['species'] as $speciesId) {
            $speciesData[$speciesId] = [
                'male_count' => $request->input("male_count.{$speciesId}", 0), // Default to 0 if not provided
                'female_count' => $request->input("female_count.{$speciesId}", 0), // Default to 0 if not provided
            ];
        }

        // Sync species to the incident with additional fields (pivot table fields)
        $poachingIncident->species()->syncWithoutDetaching($speciesData); // Assuming 'species' is the relationship method name in your Incident model

        // Redirect back with a success message
        return redirect()->route('organisation.poaching-incident-species.index', [$organisation->slug, $poachingIncident->slug])->with('success', 'Species added to incident successfully.');
    }

    public function destroy(Organisation $organisation, Incident $poachingIncident, $poachingIncidentSpecies)
    {
        $poachingIncident->species()->detach($poachingIncidentSpecies);
        return redirect()->route('organisation.poaching-incident-species.index', [$organisation->slug, $poachingIncident->slug])->with('success', 'Species removed from incident successfully.');
    }
}
