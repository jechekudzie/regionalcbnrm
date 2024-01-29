<?php

namespace App\Http\Controllers;

use App\Models\ConflictOutCome;
use App\Models\ConflictType;
use Illuminate\Http\Request;

class ConflictOutComeController extends Controller
{
    //index method passing the data to the view
    public function index()
    {
        $conflictOutcomes = ConflictOutCome::all();
        $conflictTypes = ConflictType::all();
        return view('admin.conflict_outcomes.index', compact('conflictOutcomes','conflictTypes'));
    }

    //store method
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:conflict_out_comes,name',
            'conflict_type_id' => 'required|exists:conflict_types,id',
        ]);

        $conflictOutCome = ConflictOutCome::create([
            'name' => $validated['name'],
            'conflict_type_id' => $validated['conflict_type_id'],
        ]);

        return redirect()->route('admin.conflict-outcomes.index')->with('success', 'Conflict Outcome created successfully');
    }

    //update method
    public function update(Request $request, ConflictOutCome $conflictOutCome)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'conflict_type_id' => 'required|exists:conflict_types,id',
        ]);

        $conflictOutCome->update([
            'name' => $validated['name'],
            'conflict_type_id' => $validated['conflict_type_id'],
        ]);

        return redirect()->route('admin.conflict-outcomes.index')->with('success', 'Conflict Outcome updated successfully');
    }
}
