<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\OrganisationType;
use App\Models\Species;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class OrganisationDashboardController extends Controller
{
    //
    public function dashboard()
    {
        $user = auth()->user();
        $organisations = $user->organisations;
        return view('organisation.dashboard.dashboard', compact('organisations', 'user'));
    }

    public function index(Organisation $organisation)
    {
        $user = auth()->user();
        $species = Species::all();

        return view('organisation.dashboard.index', compact('organisation', 'user', 'species'));

    }

    public function ruralDistrictCouncils()
    {
        $user = auth()->user();
        $species = Species::all();

        $organisationType = OrganisationType::where('name', 'like', '%Rural District Council%')->first();
        $ruralDistrictCouncils = Organisation::where('organisation_type_id', $organisationType->id)->get();

        return view('organisation.dashboard.organisations', compact( 'user', 'species', 'ruralDistrictCouncils'));
    }

    public function checkDashboardAccess(Organisation $organisation)
    {
        $user = auth()->user();
        $species = Species::all();

        $organisationType = OrganisationType::where('name', 'like', '%Rural District Council%')->first();
        $ruralDistrictCouncils = Organisation::where('organisation_type_id', $organisationType->id)->get();

        if ($user->hasPermissionTo('view-generic')) {
            return view('organisation.dashboard.organisations', compact('organisation', 'user', 'species', 'ruralDistrictCouncils'));
        } else {
            return view('organisation.dashboard.index', compact('organisation', 'user', 'species'));
        }

    }


}
