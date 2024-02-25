<?php

namespace App\Http\Controllers;

use App\Models\HuntingActivity;
use App\Models\HuntingDetail;
use App\Models\Organisation;
use App\Models\QuotaRequest;
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

            // Find the corresponding QuotaRequest
            $quotaRequest = QuotaRequest::find($quotaRequestId);

            // Check if QuotaRequest exists and has enough balance
            if ($quotaRequest && $quotaRequest->hunting_quota_balance >= $offtake) {
                // Subtract offtake from the hunting_quota_balance
                $quotaRequest->hunting_quota_balance -= $offtake;
                // Save the updated QuotaRequest
                $quotaRequest->save();
            } else {
                // Handle cases where the QuotaRequest doesn't exist or doesn't have enough balance
                // This might involve adding an error message to the session and redirecting back
                return back()->withErrors(['message' => 'Insufficient quota balance for '.$quotaRequest->species->name]);
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
