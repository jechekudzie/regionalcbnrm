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
    //display hunting activities
    public function index(Organisation $organisation)
    {
        $huntingActivities = HuntingActivity::where('organisation_id', $organisation->id)
            ->with('huntingLicense') // Ensure this relationship exists in the HuntingActivity model
            ->paginate(10); // Example pagination

        $huntingLicenses = $organisation->huntingLicenses; // Direct property access if you prefer

        $ruralDistrictCouncils = Organisation::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('hunting_concessions')
                ->whereColumn('hunting_concessions.organisation_id', 'organisations.id');
        })->get();

        return view('organisation.hunting_activities.index', compact('organisation', 'huntingActivities', 'huntingLicenses', 'ruralDistrictCouncils'));
    }

    //add hunting activity
    public function store(Request $request, Organisation $organisation)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'hunting_license_id' => 'nullable|exists:hunting_licenses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'hunting_concession_id' => 'required|exists:hunting_concessions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create a new hunting activity
        $huntingActivity = new HuntingActivity($validator->validated());
        $huntingActivity->organisation_id = $organisation->id;
        $huntingActivity->save();

        // Redirect back with a success message
        return redirect()->route('organisation.hunting-activities.index', $organisation->slug)
            ->with('success', 'Hunting activity added successfully.');
    }

    //display hunting activity
    public function show(Organisation $organisation, HuntingActivity $huntingActivity)
    {
        $huntingActivity->load('huntingLicense', 'huntingDetails', 'huntingVehicles', 'hunters');

        return view('organisation.hunting_activities.show', compact('organisation', 'huntingActivity'));
    }

    public function addHunterClient(Organisation $organisation, HuntingActivity $huntingActivity)
    {
        $huntingActivity->load('huntingLicense', 'huntingDetails', 'huntingVehicles', 'hunters');
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

    //saveNewHunterClient first create a hunter then add to hunting activity
    public function saveNewHunterClient(Request $request, Organisation $organisation, HuntingActivity $huntingActivity)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:hunters,email',
            'mobile_number' => 'nullable|string|max:255|unique:hunters,mobile_number',
            'country_id' => 'nullable|exists:countries,id',
        ]);

        //create hunter
        $hunter = Hunter::create($validatedData);

        //first check if hunter is already added to hunting activity
        $exists = DB::table('hunting_activity_hunter')
            ->where('hunting_activity_id', $huntingActivity->id)
            ->where('hunter_id', $hunter->id)
            ->exists();
        if ($exists) {
            return redirect()->route('organisation.hunting-activities.add-hunter-client', [$organisation->slug, $huntingActivity->slug])->with('error', 'The selected hunter is already added to this hunting activity.');
        } else {
            //attach hunter to hunting activity
            $huntingActivity->hunters()->attach($hunter->id);
            return redirect()->route('organisation.hunting-activities.add-hunter-client', [$organisation->slug, $huntingActivity->slug])->with('success', 'Hunting client added successfully.');
        }


    }

    //add hunting vehicles
    public function addHuntingVehicles(Request $request, Organisation $organisation, HuntingActivity $huntingActivity)
    {
        $vehicles = $huntingActivity->huntingVehicles()->get();
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

        $huntingActivity->huntingVehicles()->create($validatedData);

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
