<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\Species;
use Illuminate\Http\Request;

class OrganisationDashboardController extends Controller
{
    //
    public function dashboard()
    {
        $user = auth()->user();
        $organisations = $user->organisations;
        return view('organisation.dashboard.dashboard',compact('organisations','user'));
    }

    public function index(Organisation $organisation)
    {
        $user = auth()->user();
        $species = Species::all();
        return view('organisation.dashboard.index',compact('organisation','user','species'));
    }
}
