<?php

namespace App\Http\Controllers;

use App\Models\ConflictOutCome;
use App\Models\Incident;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncidentOutcomeDynamicFieldController extends Controller
{
    //index method passing the data to the view
    public function index(Organisation $organisation, Incident $incident, $incidentOutCome)
    {

        $conflictOutCome = ConflictOutCome::find($incidentOutCome);
        $fields = $conflictOutCome->dynamicFields;

        $dynamicFieldsWithValues = [];

        foreach ($conflictOutCome->dynamicFields as $field) {
            $values = DB::table('conflict_outcome_dynamic_field_values')
                ->where('dynamic_field_id', $field->id)
                ->where('incident_id', $incident->id)
                ->pluck('value'); // Assuming 'value' is the column that stores the dynamic field value

            if ($values->isNotEmpty()) {
                $dynamicFieldsWithValues[$field->label] = $values->all();
            }
        }

        return view('organisation.incidents.add_incident_dynamic_values',
            compact('fields', 'conflictOutCome','organisation','incident','incidentOutCome','dynamicFieldsWithValues'));
    }

    public function store(Request $request, Organisation $organisation, Incident $incident, $incidentOutCome)
    {
        $request->validate([
            'values' => 'required|array',
        ]);

        // Assuming you have the Incident and ConflictOutcome models available

        $conflictOutcome = ConflictOutcome::findOrFail($incidentOutCome);
        $conflictOutcomeId = $conflictOutcome->id;

        DB::beginTransaction();

        try {
            foreach ($request->input('values') as $dynamicFieldId => $value) {
                // Handle the storage of each dynamic field value
                if (is_array($value)) {
                    // For fields like checkboxes that may have multiple values
                    foreach ($value as $singleValue) {
                        $this->saveDynamicFieldValue($incident->id, $conflictOutcomeId, $dynamicFieldId, $singleValue);
                    }
                } else {
                    // For single value fields like text, select, etc.
                    $this->saveDynamicFieldValue($incident->id, $conflictOutcomeId, $dynamicFieldId, $value);
                }
            }

            DB::commit();
            return back()->with('success', 'Dynamic field values saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error saving dynamic field values: ' . $e->getMessage());
        }
    }
    protected function saveDynamicFieldValue($incidentId, $conflictOutcomeId, $dynamicFieldId, $value)
    {
        DB::table('conflict_outcome_dynamic_field_values')->insert([
            'incident_id' => $incidentId,
            'conflict_outcome_id' => $conflictOutcomeId,
            'dynamic_field_id' => $dynamicFieldId,
            'value' => $value,
            'created_at' => now(), // Manually set the timestamps
            'updated_at' => now(),
        ]);
    }


    /*protected function saveDynamicFieldValue($incidentId, $conflictOutcomeId, $dynamicFieldId, $value)
    {
        DB::table('conflict_outcome_dynamic_field_values')->updateOrInsert(
            [
                'incident_id' => $incidentId,
                'conflict_outcome_id' => $conflictOutcomeId,
                'dynamic_field_id' => $dynamicFieldId,
            ],
            ['value' => $value]
        );
    }*/


}
