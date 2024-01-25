<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Hunter;
use App\Models\HuntingActivity;
use App\Models\HuntingActivityVehicle;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class HuntingActivityController extends Controller
{
    //
    public function index(Organisation $organisation)
    {
        $huntingActivities = HuntingActivity::where('organisation_id', $organisation->id)
            ->with('huntingLicense') // Assuming a relationship named 'huntingLicense'
            ->get();
        $huntingLicenses = $organisation->huntingLicenses()->get();

        return view('organisation.hunting_activities.index', compact('organisation',
            'huntingActivities', 'huntingLicenses'));
    }

    public function store(Request $request, Organisation $organisation)
    {
        $validatedData = $request->validate([
            'organisation_id' => 'required|exists:organisations,id',
            'hunting_license_id' => 'required|exists:hunting_licenses,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $organisation->huntingActivities()->create($validatedData);

        return redirect()->route('organisation.hunting-activities.index', $organisation->slug)->with('success', 'Hunting activity added successfully.');
    }


    public function addHunterClient(Organisation $organisation, HuntingActivity $huntingActivity)
    {
        $huntingActivity->load('huntingLicense', 'huntingDetails', 'vehicles', 'hunters');
        $hunters = Hunter::all();
        $countries = Country::all();
        return view('organisation.hunting_activities.add_hunting_client', compact('organisation',
            'huntingActivity', 'hunters', 'countries'));
    }

    public function saveHunterClient(Organisation $organisation, HuntingActivity $huntingActivity, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hunter_id' => [
                'required',
                'exists:hunters,id',
                function ($attribute, $value, $fail) use ($request) {
                    $huntingActivityId = $request->input('hunting_activity_id');
                    $exists = DB::table('hunting_activity_hunter')
                        ->where('hunting_activity_id', $huntingActivityId)
                        ->where('hunter_id', $value)
                        ->exists();
                    if ($exists) {
                        $fail('The selected hunter is already added to this hunting activity.');
                    }
                },
            ],
            // other fields...
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the validated data
        $validatedData = $validator->validated();

        // Attach the hunter to the hunting activity
        $huntingActivity->hunters()->attach($validatedData['hunter_id']);

        return redirect()->route('organisation.hunting-activities.add-hunter-client', [$organisation->slug, $huntingActivity->slug])->with('success', 'Hunting client added successfully.');
    }

    public function show(Organisation $organisation, HuntingActivity $huntingActivity)
    {
        $huntingActivity->load('huntingLicense', 'huntingDetails', 'vehicles', 'hunters');

        return view('organisation.hunting_activities.show', compact('organisation', 'huntingActivity'));
    }
    //add hunting vehicles
    public function addHuntingVehicles(Request $request, Organisation $organisation, HuntingActivity $huntingActivity)
    {
        $vehicles = $huntingActivity->vehicles()->get();
        return view('organisation.hunting_activities.add_hunting_vehicles', compact('huntingActivity',
            'organisation', 'vehicles'));
    }

    public function saveHuntingVehicles(Request $request, Organisation $organisation, HuntingActivity $huntingActivity)
    {
        $validatedData = $request->validate([
            'vehicle_type' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'driver' => 'nullable|string|max:255',
        ]);

        $huntingActivity->vehicles()->create($validatedData);

        return redirect()->route('organisation.hunting-activities.add-hunting-vehicles', [$organisation->slug, $huntingActivity->slug])
            ->with('success', 'Vehicle added successfully to the hunting activity.');
    }

    public function updateHuntingVehicles(Request $request, Organisation $organisation, HuntingActivityVehicle $huntingActivityVehicle)
    {

        $validatedData = $request->validate([
            'vehicle_type' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'driver' => 'nullable|string|max:255',
        ]);

        $huntingActivityVehicle->update($validatedData);

        $huntingActivity = $huntingActivityVehicle->huntingActivity;
        return redirect()->route('organisation.hunting-activities.add-hunting-vehicles', [$organisation->slug, $huntingActivity->slug])
        ->with('success', 'Vehicle updated successfully to the hunting activity.');
    }
}
