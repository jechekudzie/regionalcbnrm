<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\OrganisationType;
use Illuminate\Http\Request;

class OrganisationsController extends Controller
{

    public function index()
    {
        return view('admin.organisations.index');
    }

    //store organisation of organisation
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'organisation_type_id' => 'required|exists:organisation_types,id',
                // other fields to validate
            ]);

            $organisation = Organisation::create($validatedData);

            // Find parent OrganisationType
            $organisationType = OrganisationType::find($validatedData['organisation_type_id']);
            $parentOrganisationType = $organisationType->parents()->first();
            if ($parentOrganisationType) {
                $parentOrganisation = Organisation::where('organisation_type_id', $parentOrganisationType->id)->first();
                if ($parentOrganisation) {
                    $organisation->organisation_id = $parentOrganisation->id;
                }
            }
            $organisation->save();

            // Create admin role
            $organisation->organisationRoles()->create([
                'name' => 'admin',
                'guard_name' => 'web',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Organisation created successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->getMessageBag()->toArray()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    public function update(Organisation $organisation)
    {
        $data = request()->validate([
            'name' => 'required',
        ]);

        $organisation->update($data);
        return redirect()->route('admin.organisations.index')->with('success', 'Organisation created successfully');
    }


    public function destroy(Organisation $organisation)
    {
        $organisation->delete();
        return redirect()->route('admin.organisations.index')->with('success', 'Organisation deleted successfully');
    }

    public function manageOrganisations()
    {
        //all organisations sort by organisation type
        $organisations = Organisation::all()->sortBy('organisation_type_id');
        return view('admin.organisations.manage', compact('organisations'));

    }

}
