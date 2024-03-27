<?php

namespace App\Http\Controllers;

use App\Models\ControlMeasure;
use App\Models\Incident;
use App\Models\Organisation;
use App\Models\PACDetail;
use App\Models\ProblemAnimalControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProblemAnimalControlController extends Controller
{
    //
    public function index(Organisation $organisation)
    {
        // Fetch ProblemAnimalControls associated with the organisation, in descending order
        $problemAnimalControls = ProblemAnimalControl::with(['pacDetails.species', 'pacDetails.controlMeasures'])
            ->where('organisation_id', $organisation->id)
            ->orderByDesc('created_at')
            ->get();

        // Flatten the PAC details as they are nested within ProblemAnimalControls
        $pacDetails = $problemAnimalControls->flatMap(function ($pac) {
            return $pac->pacDetails;
        });

        return view('organisation.problem_animal_control.index', compact('pacDetails', 'organisation'));
    }

    public function create(Organisation $organisation, Incident $incident)
    {

        $incident = Incident::with('problemAnimalControls.pacDetails.species', 'problemAnimalControls.pacDetails.controlMeasures')
            ->where('id', $incident->id)
            ->firstOrFail();

        // Flatten the PAC details as they are nested within ProblemAnimalControls
        $pacDetails = $incident->problemAnimalControls->flatMap(function ($pac) {
            return $pac->pacDetails;
        });

        return view('organisation.problem_animal_control.create', compact('pacDetails', 'organisation','incident'));
    }

    public function store(Request $request, Organisation $organisation, Incident $incident)
    {
        // Begin a transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Create the ProblemAnimalControl entry if it doesn't exist
            $problemAnimalControl = ProblemAnimalControl::firstOrCreate([
                'organisation_id' => $organisation->id,
                'incident_id' => $incident->id,
            ]);

            // Loop through the submitted species data
            foreach ($request->input('species', []) as $speciesId => $details) {
                // Check if there are control measures for the current species
                if (isset($request->control_measures[$speciesId]) && !empty($request->control_measures[$speciesId])) {
                    // Retrieve or create a PACDetail entry for each species
                    $pacDetail = PACDetail::updateOrCreate([
                        'problem_animal_control_id' => $problemAnimalControl->id,
                        'species_id' => $speciesId,
                    ], [
                        // Additional fields to be updated or set can be placed here
                    ]);

                    // Loop through the control measures and attach/update them to the PACDetail
                    foreach ($request->control_measures[$speciesId] as $controlMeasureId) {
                        // Check if the control measure is already attached and update it
                        if ($pacDetail->controlMeasures()->where('control_measure_id', $controlMeasureId)->exists()) {
                            $pacDetail->controlMeasures()->updateExistingPivot($controlMeasureId, [
                                'male_count' => $details['male_count'] ?? null,
                                'female_count' => $details['female_count'] ?? null,
                                'location' => $details['location'] ?? null,
                                'latitude' => $details['latitude'] ?? null,
                                'longitude' => $details['longitude'] ?? null,
                                'remarks' => $details['remarks'] ?? null,
                            ]);
                        } else {
                            // If the control measure is not attached, attach it with details
                            $pacDetail->controlMeasures()->attach($controlMeasureId, [
                                'male_count' => $details['male_count'] ?? null,
                                'female_count' => $details['female_count'] ?? null,
                                'location' => $details['location'] ?? null,
                                'latitude' => $details['latitude'] ?? null,
                                'longitude' => $details['longitude'] ?? null,
                                'remarks' => $details['remarks'] ?? null,
                            ]);
                        }
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            // Redirect or return success response
            return redirect()->route('organisation.problem-animal-control.create', [$organisation->slug, $incident->slug])->with('success', 'Problem Animal Control details updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollback();

            // Redirect or return error response
            return back()->withErrors(['msg' => 'An error occurred: ' . $e->getMessage()]);
        }
    }


    //show
    public function show(Organisation $organisation, $detailId)
    {
        // Retrieve the detail using the provided ID
        $detail = PACDetail::findOrFail($detailId);

        // Optionally, you might want to ensure that the detail belongs to the specified organization
        // This can be done by adding additional checks here, depending on your database structure

        // Pass the detail to the view
        return view('organisation.problem_animal_control.show', compact('detail', 'organisation'));
    }

    public function edit(Organisation $organisation, $detailId)
    {
        // Retrieve the detail using the provided ID
        $detail = PACDetail::findOrFail($detailId);

        //dd($detail->controlMeasures);
        $incident = $detail->problemAnimalControl->incident;
        // Optionally, you might want to ensure that the detail belongs to the specified organization and incident
        // This can be done by adding additional checks here, depending on your database structure

        // Retrieve all control measures to display in the form
        $controlMeasures = ControlMeasure::all();

        // Pass the detail and control measures to the view
        return view('organisation.problem_animal_control.edit', compact('detail', 'controlMeasures','organisation','incident'));
    }

    public function update(Request $request, Organisation $organisation, $detailId)
    {
        $detail = PACDetail::findOrFail($detailId); // Make sure the detail exists

        // Validate the request here if necessary
        $validated = $request->validate([
            'control_measures' => 'nullable|array',
            'control_measures.*' => 'exists:control_measures,id', // Ensures only existing control measures IDs are allowed
            // Add validation for other fields as needed
        ]);

        // Update the PACDetail entity if necessary
        // $detail->update([...]);

        // Sync control measures
        $currentControlMeasures = $detail->controlMeasures->pluck('id')->toArray();
        $submittedControlMeasures = $request->input('control_measures', []);

        foreach ($currentControlMeasures as $measureId) {
            if (!in_array($measureId, $submittedControlMeasures)) {
                // If a current control measure was not in the submitted list, detach it
                $detail->controlMeasures()->detach($measureId);
            } else {
                // If it was submitted, update pivot data
                $detail->controlMeasures()->updateExistingPivot($measureId, [
                    'male_count' => $request->input('male_count'),
                    'female_count' => $request->input('female_count'),
                    'location' => $request->input('location'),
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'remarks' => $request->input('remarks'),
                ]);
            }
        }

        // Attach new control measures if any
        foreach ($submittedControlMeasures as $measureId) {
            if (!in_array($measureId, $currentControlMeasures)) {
                $detail->controlMeasures()->attach($measureId, [
                    'male_count' => $request->input('male_count'),
                    'female_count' => $request->input('female_count'),
                    'location' => $request->input('location'),
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'remarks' => $request->input('remarks'),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Details updated successfully.');
    }


}
