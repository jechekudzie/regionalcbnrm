<?php

namespace App\Http\Controllers;

use App\Models\CountingMethod;
use App\Models\Maturity;
use App\Models\Organisation;
use App\Models\PopulationEstimate;
use App\Models\Species;
use App\Models\SpeciesGender;
use Illuminate\Http\Request;

class PopulationEstimateController extends Controller
{
    //
    public function species(Organisation $organisation){
        $species = Species::all();
        return view('organisation.population-estimates.species', compact('organisation', 'species'));

    }
    public function index(Organisation $organisation,Species $species)
    {
        $mySelectedSpecies = $species;
        $selectedSpecies = Species::with('populationEstimates.countingMethod')->findOrFail($species->id);
        $distinctYears = $selectedSpecies->populationEstimates()
            ->select('year')
            ->distinct()
            ->pluck('year');
        $maturities = Maturity::all();
        $genders = SpeciesGender::all();
        $countingMethods = CountingMethod::all();

        return view('organisation.population-estimates.index', compact('selectedSpecies', 'distinctYears',
            'maturities', 'genders','organisation','countingMethods','mySelectedSpecies'));
    }

    public function store(Request $request,Organisation $organisation)
    {
        // Validate the request
        $validatedData = $request->validate([
            'species_id' => 'required|exists:species,id',
            'year' => 'required|integer|min:2015|max:' . (now()->year + 1),
            'counting_method_id' => 'required|exists:counting_methods,id',
            'estimates' => 'required|array',
        ]);

        $species = Species::findOrFail($validatedData['species_id']);

        // Iterate over the estimates and save them
        foreach ($validatedData['estimates'] as $maturityId => $genderEstimates) {
            foreach ($genderEstimates as $genderId => $estimateValue) {
                PopulationEstimate::updateOrCreate(
                    [
                        'species_id' => $validatedData['species_id'],
                        'year' => $validatedData['year'],
                        'counting_method_id' => $validatedData['counting_method_id'],
                        'maturity_id' => $maturityId,
                        'species_gender_id' => $genderId,
                    ],
                    ['estimate' => $estimateValue]
                );
            }
        }
        // Redirect the user back to a previous page with a success message
        return redirect()->route('organisation.population-estimates.index', [$organisation->slug, $species->slug])
            ->with('success', 'Population Estimate created successfully.');
    }
    public function byCountingMethods(Organisation $organisation)
    {
        $distinctYears = PopulationEstimate::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $species = Species::with(['populationEstimates' => function ($query) use ($distinctYears) {
            $query->whereIn('year', $distinctYears->toArray())
                ->with('countingMethod');
        }])->get();

        $maturities = Maturity::all();
        $genders = SpeciesGender::all();

        return view('organisation.population-estimates.index_by_counting_method', compact('species', 'distinctYears',
            'maturities', 'genders','organisation'));
    }




}
