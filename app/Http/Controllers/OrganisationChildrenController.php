<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\OrganisationType;
use Illuminate\Http\Request;

class OrganisationChildrenController extends Controller
{
    //
    public function index(Organisation $organisation, OrganisationType $organisationType)
    {

       //dd( $organisationType->parentOrganisationType()->name);
        return view('organisation.organisation_children.index',compact('organisation','organisationType'));
    }

    //store organisation of organisation
    public function store(Organisation $organisation, OrganisationType $organisationType, Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $organisation->organisations()->create([
                'name' => $validatedData['name'],
                'organisation_type_id' => $organisationType->id,
               /* 'organisation_id' => $organisation->id,*/
            ]);

            return redirect()->route('organisation.organisations.index', [$organisation->slug,$organisationType->slug])->with('success', 'Organisation created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('organisation.organisations.index', [$organisation->slug,$organisationType->slug])->with('error', 'Organisation not created');
        } catch (\Exception $e) {
            return redirect()->route('organisation.organisations.index', [$organisation->slug,$organisationType->slug])->with('error', 'Organisation not created');
        }
    }

    public function update(Organisation $organisation, Organisation $organisationToUpdate,Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $organisationToUpdate->update([
            'name' => $validatedData['name'],
        ]);

       return redirect()->route('organisation.organisations.index', [$organisation->slug,$organisationToUpdate->organisationType->slug])->with('success', 'Organisation updated successfully');
    }

    //destroy organisation of organisation
    public function destroy(Organisation $organisation, Organisation $organisationToDelete)
    {
        $organisationToDelete->delete();

        return redirect()->route('organisation.organisations.index', [$organisation->slug,$organisationToDelete->organisationType->slug])->with('success', 'Organisation deleted successfully');
    }

}
