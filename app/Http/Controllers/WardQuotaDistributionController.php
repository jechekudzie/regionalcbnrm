<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\QuotaRequest;
use App\Models\WardQuotaDistribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class WardQuotaDistributionController extends Controller
{
    //index
    public function index(Organisation $organisation,QuotaRequest $quotaRequest)
    {

        $wards = $organisation->firstGroupOfChildOrganisations();
        $wardQuotaDistributions = WardQuotaDistribution::all();
        return view('organisation.quota_settings.ward_quota_distribution', compact('wardQuotaDistributions','wards','quotaRequest','organisation'));
    }

    public function store(Request $request, Organisation $organisation, QuotaRequest $quotaRequest)
    {

        // Ensure the organisation and quota request are valid and related
        if (!$organisation || !$quotaRequest) {
            return back()->withErrors(['error' => 'Invalid organisation or quota request.']);
        }

        $wardsData = $request->input('wards', []);

        foreach ($wardsData as $wardId => $data) {
            // Validate each ward's quota data
            $validatedData = Validator::make($data, [
                'ward_id' => 'required|exists:organisations,id',
                'hunting_quota' => 'nullable|numeric|min:0',
                'pac_quota' => 'nullable|numeric|min:0',
                'rational_quota' => 'nullable|numeric|min:0',
            ])->validate();

            // Find the ward organisation
            $ward = Organisation::findOrFail($wardId);

            // Create or update the WardQuotaDistribution
            WardQuotaDistribution::updateOrCreate(
                [
                    'quota_request_id' => $quotaRequest->id,
                    'ward_id' => $wardId,
                ],
                [
                    'hunting_quota' => $validatedData['hunting_quota'],
                    'pac_quota' => $validatedData['pac_quota'],
                    'rational_quota' => $validatedData['rational_quota'],
                ]
            );
        }

        return redirect()->back()->with('success', 'Quota distributions have been successfully updated.');
    }

    //update method for a single ward
    public function update(Request $request, Organisation $organisation, QuotaRequest $quotaRequest, WardQuotaDistribution $wardQuotaDistribution)
    {
        // Ensure the organisation and quota request are valid and related
        if (!$organisation || !$quotaRequest) {
            return back()->withErrors(['error' => 'Invalid organisation or quota request.']);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'hunting_quota' => 'nullable|numeric|min:0',
            'pac_quota' => 'nullable|numeric|min:0',
            'rational_quota' => 'nullable|numeric|min:0',
        ]);

        // Update the WardQuotaDistribution
        $wardQuotaDistribution->update($validatedData);

        return redirect()->back()->with('success', 'Quota distribution has been successfully updated.');
    }



}
