<?php

namespace App\Http\Controllers;

use App\Models\HuntingLicense;
use App\Models\Organisation;
use Illuminate\Http\Request;

class HuntingLicenseController extends Controller
{
    //

    public function index(Organisation $organisation)
    {
        $huntingLicenses = HuntingLicense::with('organisation')->get();
        return view('organisation.safari_licenses.index', compact('huntingLicenses', 'organisation'));
    }

    public function store(Request $request,Organisation $organisation)
    {
        $validatedData = $request->validate(
            [
                'license_number' => 'required|string',
            ]);

        //create
        $organisation->huntingLicenses()->create($validatedData);

        return redirect()->route('organisation.safari-licenses.index',$organisation->slug)->with('success', 'Hunting license added successfully.');
    }
}
