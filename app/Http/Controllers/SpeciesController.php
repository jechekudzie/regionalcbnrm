<?php

namespace App\Http\Controllers;

use App\Models\Species;
use Illuminate\Http\Request;

class SpeciesController extends Controller
{
    //index
    public function index()
    {
        $species = Species::all();
        return view('admin.species.index',compact('species'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'scientific' => 'nullable|string|max:255',
            'male_name' => 'nullable|string|max:255',
            'female_name' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_special' => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('avatar')) {
            $avatarName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('images'), $avatarName);
            $avatarName = '/images/' . $avatarName; // Store the path as /images/avatarName
        } else {
            $avatarName = null;
        }

        // Create a new species instance and save it to the database
        $species =  Species::create([
            'name' => $request->name,
            'scientific' => $request->scientific,
            'male_name' => $request->male_name,
            'female_name' => $request->female_name,
            'avatar' => $avatarName,
            'is_special' => $request->has('is_special'),
        ]);


        // Redirect to a specified route with a success message
        return redirect()->route('admin.species.index')->with('success', 'Species added successfully.');
    }
}
