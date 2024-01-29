<?php

namespace App\Http\Controllers;

use App\Models\ConflictOutCome;
use Illuminate\Http\Request;

class DynamicFieldController extends Controller
{
    //index method passing the data to the view
    public function index(ConflictOutCome $conflictOutCome)
    {
        $fields = $conflictOutCome->fields;
        return view('admin.organisation.add_dynamic_field', compact('fields'));
    }
}
