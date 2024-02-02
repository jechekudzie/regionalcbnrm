<?php

namespace App\Http\Controllers;

use App\Models\HuntingActivity;
use App\Models\HuntingDetail;
use App\Models\Organisation;
use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HuntingDetailsController extends Controller
{
    //index
    public function index(Request $request, Organisation $organisation, HuntingActivity $huntingActivity)
    {
        $huntingActivity->load( 'huntingDetails', 'huntingVehicles', 'hunters');

        return view('organisation.hunting_activities.add_species_details', compact('organisation',
            'huntingActivity'));

    }

    //store
   /* public function store(Request $request, Organisation $organisation, HuntingActivity $huntingActivity)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'hunting_concession_id' => 'required|exists:hunting_concessions,id',
            'species_id.*' => 'required|exists:species,id',
            'quota_request_id.*' => 'required|exists:quota_requests,id',
            'offtake.*' => 'nullable', // Validation rule for offtake can be specified here
            'rbz_trastool_number.*' => 'nullable', // Validation rule for RBZ Trastool Number
            'is_special.*' => 'boolean', // Validation rule for identifying special hunting cases
        ]);

        // Initialize validation state and error messages container
        $isValid = true;
        $errorMessages = [];

        // Pre-validation for special conditions
        foreach ($validatedData['species_id'] as $key => $speciesId) {
            if (isset($validatedData['is_special'][$key]) && $validatedData['is_special'][$key]) {
                // Ensure RBZ Trastool Number is provided for special species
                if (!isset($validatedData['rbz_trastool_number'][$key]) || empty($validatedData['rbz_trastool_number'][$key])) {
                    $isValid = false; // Flag indicating invalid data
                    // Construct an error message with the species name for user clarity
                    $errorMessages[] = "RBZ Trastool Number is required for hunting special animals like " . Species::find($speciesId)->name;
                }
            }
        }

        // Return with errors if validation fails
        if (!$isValid) {
            $errorBag = new \Illuminate\Support\MessageBag($errorMessages);
            return back()->withErrors($errorBag); // Redirect back with error messages
        }

        // Process each hunting detail submission
        foreach ($validatedData['species_id'] as $key => $speciesId) {

            if (!isset($validatedData['quota_request_id'][$key])) {
                continue; // Skip this iteration if quota_request_id is missing
            }

            $quotaRequestId = $validatedData['quota_request_id'][$key]; // Now safely accessed

            // Check for existing hunting detail record
            $existingHuntingDetail = $huntingActivity->huntingDetails()
                ->where('species_id', $speciesId)
                ->where('quota_request_id', $quotaRequestId) // Adjusted to use the safely accessed variable
                ->first();


            if ($existingHuntingDetail) {
                // Update offtake for existing records, if provided
                if (isset($validatedData['offtake'][$key])) {
                    $existingHuntingDetail->offtake = $validatedData['offtake'][$key] ?? null;
                    $existingHuntingDetail->save(); // Persist changes
                }
            } else {
                // Create new record if offtake is provided
                if (isset($validatedData['offtake'][$key]) && $validatedData['offtake'][$key] !== null) {
                    $huntingDetail = new HuntingDetail();
                    // Assigning field values to the new HuntingDetail instance
                    $huntingDetail->hunting_activity_id = $huntingActivity->id;
                    $huntingDetail->hunting_concession_id = $validatedData['hunting_concession_id'];
                    $huntingDetail->species_id = $speciesId;
                    $huntingDetail->quota_request_id = $validatedData['quota_request_id'][$key];
                    $huntingDetail->offtake = $validatedData['offtake'][$key];

                    // Assign RBZ Trastool Number if available, otherwise set to null
                    $huntingDetail->rbz_trastool_number = $validatedData['rbz_trastool_number'][$key] ?? null;
                    $huntingDetail->is_special = $validatedData['is_special'][$key];

                    $huntingDetail->save(); // Save the new HuntingDetail instance
                }
            }
        }

        // Redirect to the species details page with the organisation and hunting activity slugs
        return redirect()->route('organisation.hunting-activities.species-details', [$organisation->slug, $huntingActivity->slug]);
    }*/


        public function store(Request $request, Organisation $organisation, HuntingActivity $huntingActivity)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'hunting_concession_id' => 'required|exists:hunting_concessions,id',
            'species_id.*' => 'required|exists:species,id',
            'quota_request_id.*' => 'required|exists:quota_requests,id',
            'offtake.*' => 'nullable|numeric|min:0',
            'rbz_trastool_number.*' => 'nullable|string',
            'is_special.*' => 'boolean',
        ]);

        // Extract arrays from validated data
        $speciesIds = $validatedData['species_id'] ?? [];
        $quotaRequestIds = $validatedData['quota_request_id'] ?? [];
        $offtakes = $validatedData['offtake'] ?? [];
        $rbzTrastoolNumbers = $validatedData['rbz_trastool_number'] ?? [];
        $isSpecialFlags = $validatedData['is_special'] ?? [];

        // Iterate through the species IDs
        foreach ($speciesIds as $index => $speciesId) {
            $quotaRequestId = $quotaRequestIds[$index] ?? null;
            $offtake = $offtakes[$index] ?? null;

            // Skip this iteration if there's no offtake value
            if (is_null($offtake) || $offtake <= 0) {
                continue;
            }

            // Prepare data for the new or existing hunting detail
            $detailData = [
                'hunting_activity_id' => $huntingActivity->id,
                'hunting_concession_id' => $validatedData['hunting_concession_id'],
                'species_id' => $speciesId,
                'quota_request_id' => $quotaRequestId,
                'offtake' => $offtake,
                'rbz_trastool_number' => $rbzTrastoolNumbers[$index] ?? null,
                'is_special' => $isSpecialFlags[$index] ?? false,
            ];

            // Check for an existing hunting detail record for the species in the given period
            $existingHuntingDetail = $huntingActivity->huntingDetails()
                ->where('species_id', $speciesId)
                ->where('quota_request_id', $quotaRequestId)
                ->first();

            if ($existingHuntingDetail) {
                // Update existing record
                $existingHuntingDetail->update($detailData);
            } else {
                // Create new record
                HuntingDetail::create($detailData);
            }
        }

        // Redirect to the species details page with the organisation and hunting activity slugs
        return redirect()->route('organisation.hunting-activities.species-details', [$organisation->slug, $huntingActivity->slug])
            ->with('success', 'Hunting details successfully saved.');
    }






}
