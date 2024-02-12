<?php

namespace App\Http\Controllers;

use App\Models\ConflictOutCome;
use App\Models\Incident;
use App\Models\Organisation;
use Illuminate\Http\Request;

class IncidentOutcomeController extends Controller
{
    //
    public function index(Organisation $organisation, Incident $incident)
    {
        $incidentOutcomes = $incident->ConflictOutComes()->get();

        $ConflictOutComes = ConflictOutCome::all();
        return view('organisation.incidents.add_incident_outcomes', compact('ConflictOutComes','incidentOutcomes', 'incident', 'organisation'));
    }

    public function store(Request $request, Organisation $organisation, Incident $incident)
    {

        // Validate the request
        $validated = $request->validate([
            'conflict_outcomes' => 'required|array',
            'conflict_outcomes.*' => 'exists:conflict_out_comes,id', // Ensure each conflict_outcomes ID exists in the database
        ]);

        $incident->ConflictOutComes()->syncWithoutDetaching($validated['conflict_outcomes']);
        // Where $validated['conflict_outcomes'] is an array of conflict_outcomes IDs.

        // Redirect back with a success message
        return redirect()->route('organisation.incident-outcomes.index', [$organisation->slug,$incident->slug])->with('success', 'Conflict Outcome added to incident successfully.');
    }

    public function destroy(Organisation $organisation, Incident $incident, $incidentOutcome)
    {

        $incident->ConflictOutComes()->detach($incidentOutcome);
        return redirect()->route('organisation.incident-outcomes.index', [$organisation->slug,$incident->slug])->with('success', 'Conflict Outcome removed from incident successfully.');
    }
}
