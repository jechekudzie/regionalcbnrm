<?php

namespace App\Http\Controllers;

use App\Models\ConflictOutCome;
use App\Models\DynamicField;
use Illuminate\Http\Request;

class DynamicFieldController extends Controller
{
    //index method passing the data to the view
    public function index(ConflictOutCome $conflictOutCome)
    {
        $fields = $conflictOutCome->dynamicFields()->get();
        return view('admin.conflict_outcomes.add_dynamic_fields', compact('fields','conflictOutCome'));
    }

    //store method to store the data
    public function store(Request $request, ConflictOutCome $conflictOutCome)
    {
        $request->validate([
            'field_name' => 'required',
            'field_type' => 'required',
        ]);
        $conflictOutCome->dynamicFields()->create($request->all());
        return redirect()->back()->with('success', 'Field added successfully.');
    }

    //update method to update the data
    public function update(Request $request, ConflictOutCome $conflictOutCome,DynamicField $dynamicField)
    {
        $request->validate([
            'field_name' => 'required',
            'field_type' => 'required',
            'label' => 'required',
        ]);
        $dynamicField->update($request->all());
        return redirect()->back()->with('success', 'Field updated successfully.');
    }
}
