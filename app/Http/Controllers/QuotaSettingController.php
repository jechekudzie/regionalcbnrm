<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\QuotaRequest;
use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class QuotaSettingController extends Controller
{
    //

    public function species(Organisation $organisation)
    {
        $species = Species::all();
        return view('organisation.quota_settings.species', compact('organisation', 'species'));

    }

    public function index(Organisation $organisation, Species $species)
    {
        $selectedSpecies = Species::findOrFail($species->id);
        $quotaRequests = QuotaRequest::where('species_id', $species->id)
            ->orderBy('year', 'desc')
            ->get();

        return view('organisation.quota_settings.index', compact('selectedSpecies', 'quotaRequests', 'organisation'));

    }
    public function store(Request $request, Organisation $organisation)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [

            'species_id' => 'required|exists:species,id',
            'organisation_id' => 'required|exists:organisations,id',
            'year' => [
                'required',
                'integer',
                'min:2015',
                'max:' . (now()->year + 1),
                function ($attribute, $value, $fail) use ($request) {
                    if (QuotaRequest::where('species_id', $request->species_id)
                        ->where('year', $value)
                        ->exists()) {
                        $fail('A quota request for this species and year already exists.');
                    }
                },
            ],
            'initial_quota' => 'required|integer',
            'rdc_quota' => 'nullable|integer',
            'campfire_quota' => 'nullable|integer',
            'zimpark_station_quota' => 'nullable|integer',
            'national_park_quota' => 'nullable|integer',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $quotaRequest = new QuotaRequest($validator->validated());
        $quotaRequest->save();


        $species = Species::findOrFail($request->species_id);
        // Redirect back with a success message
        return redirect()->route('organisation.quota-settings.index', [$organisation->slug, $species->slug])->with('success', 'Quota request submitted successfully.');
    }

    public function edit(Organisation $organisation,QuotaRequest $quotaRequest)
    {
        $selectedSpecies = Species::findOrFail($quotaRequest->species->id);

        return view('organisation.quota_settings.edit', compact('selectedSpecies', 'quotaRequest', 'organisation'));


    }

    public function update(Request $request, Organisation $organisation, QuotaRequest $quotaRequest)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'species_id' => 'required|exists:species,id',
            'organisation_id' => 'required|exists:organisations,id',
            'year' => 'required|integer|min:2015|max:' . (now()->year + 1),
            'initial_quota' => 'nullable|integer',
            'rdc_quota' => 'nullable|integer',
            'campfire_quota' => 'nullable|integer',
            'zimpark_station_quota' => 'nullable|integer',
            'national_park_quota' => 'nullable|integer',
        ]);


        // Update the record with validated data
        $quotaRequest->update($validatedData);

        // Redirect back or to another page with a success message
        return redirect()->route('organisation.quota-settings.index', [$organisation->slug,$quotaRequest->species->slug])
            ->with('success', 'Quota request updated successfully.');
    }


}
