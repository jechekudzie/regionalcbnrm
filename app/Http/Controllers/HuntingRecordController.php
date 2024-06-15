<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\OrganisationType;
use App\Models\Species;
use App\Models\HuntingRecord;
use Illuminate\Http\Request;

class HuntingRecordController extends Controller
{
    public function create()
    {
        //$organisations = Organisation::all();
        $species = Species::all();
        $years = range(2018, date('Y') + 1);
        $huntingRecords = HuntingRecord::all();

        $organisationType = OrganisationType::where('name', 'like', '%Rural District Council%')->first();
        $organisations = Organisation::where('organisation_type_id', $organisationType->id)->get();

       echo "<pre>";
       //echo id and name for organisations
        foreach ($organisations as $organisation) {
            echo $organisation->id . " " . $organisation->name . "<br>";
        }

        //put a break
        echo "<br>";
        echo "<br>";
        echo "<br>";


        //do same for species
        foreach ($species as $specie) {
            echo $specie->id . " " . $specie->name . "<br>";
        }

        //return view('reports.hunting_records.create', compact('organisations', 'species', 'years','huntingRecords'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'organisation_id' => 'required|exists:organisations,id',
            'period' => 'required|integer|min:2018|max:' . (date('Y') + 1),
            'records.*.species_id' => 'nullable|exists:species,id',
            'records.*.allocated' => 'nullable|integer',
            'records.*.utilised' => 'nullable|integer',
        ]);

        foreach ($data['records'] as $recordData) {
            if (isset($recordData['species_id'])) {
                HuntingRecord::create([
                    'organisation_id' => $data['organisation_id'],
                    'species_id' => $recordData['species_id'],
                    'period' => $data['period'],
                    'allocated' => $recordData['allocated'] ?? 0,
                    'utilised' => $recordData['utilised'] ?? 0,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Records saved successfully.');
    }

}
