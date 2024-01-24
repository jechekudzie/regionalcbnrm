<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use Illuminate\Http\Request;

class OrganisationDashboardController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        $organisations = $user->organisations;
        return view('organisation.dashboard.index',compact('organisations','user'));
    }
}
