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
                'required', 'integer', 'min:2015', 'max:' . (now()->year + 1),
                function ($attribute, $value, $fail) use ($request) {
                    // Including hunting_concession_id in the uniqueness check
                    if (QuotaRequest::where('organisation_id', $request->organisation_id)
                        ->where('species_id', $request->species_id)
                        ->where('year', $value)
                        ->exists()) {
                        $fail('A quota request for this RDC, species, and year already exists.');
                    }
                },
            ],
            'proposed_hunting_quota' => 'required|integer',
            'hunting_quota' => 'required|integer',
            'rational_quota' => 'nullable|integer',
            'zimpark_hunting_quota' => 'nullable|integer',
            'zimpark_pac_quota' => 'nullable|integer',
            'zimpark_rational_quota' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $quotaRequest = new QuotaRequest($validator->validated());
        $quotaRequest->save();

        //update the hunting_quota_balance and relational_quota_balance
        $quotaRequest->update([
            'hunting_quota_balance' => $quotaRequest->hunting_quota,
            'rational_quota_balance' => $quotaRequest->rational_quota
        ]);

        $species = Species::findOrFail($request->species_id);

        // Assuming you want to redirect to a general quota settings index page, not specific to a species
        return redirect()->route('organisation.quota-settings.index',[ $organisation->slug,$species->slug])
            ->with('success', 'Quota request submitted successfully.');
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
            'proposed_hunting_quota' => 'required|integer',
            'hunting_quota' => 'required|integer',
            'rational_quota' => 'nullable|integer',
            'zimpark_hunting_quota' => 'nullable|integer',
            'zimpark_pac_quota' => 'nullable|integer',
            'zimpark_rational_quota' => 'nullable|integer',
        ]);


        // Update the record with validated data
        $quotaRequest->update($validatedData);

        // Redirect back or to another page with a success message
        return redirect()->route('organisation.quota-settings.index', [$organisation->slug,$quotaRequest->species->slug])
            ->with('success', 'Quota request updated successfully.');
    }


}
