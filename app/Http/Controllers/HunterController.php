<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Hunter;
use App\Models\Organisation;
use Illuminate\Http\Request;

class HunterController extends Controller
{
    //create index
    public function index(Organisation $organisation)
    {
        $hunters = Hunter::all();
        $countries = Country::all();
        return view('organisation.hunters.index', compact('hunters', 'countries','organisation'));
    }
    public function store(Request $request,Organisation $organisation)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile_number' => 'nullable|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
        ]);

        //create hunter
        Hunter::create($validatedData);

        return redirect()->route('organisation.hunters.index',$organisation->slug)->with('success', 'New hunter added successfully.');
    }

    public function destroy(Organisation $organisation, Hunter $hunter)
    {

        $hunter->delete();

        return redirect()->route('organisation.hunters.index',$organisation->slug)->with('success', 'Hunter deleted successfully.');
    }
}
