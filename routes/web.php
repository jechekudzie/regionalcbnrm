<?php

use App\Http\Controllers\OrganisationsController;
use App\Http\Controllers\OrganisationRolesController;
use App\Http\Controllers\OrganisationTypeController;
use App\Http\Controllers\OrganisationUsersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', function () {

    foreach (\App\Models\Species::all() as $specie){
        echo $specie->name.' '.'<img src="'.$specie->avatar.'" width="100px" height="100px">'.'<br>';
    }

    /*$organisation = \App\Models\Organisation::find(3);
    $organisation->organisationType->children->map(function ($item) use ($organisation) {
        $item->organisation_id = $organisation->id;
    });

    // Assuming $organisation is an instance of Organisation
    $parentOrganisation = $organisation->parentOrganisation; // This will get the parent Organisation

    dd($parentOrganisation);

    $string = "687549-ot-1";
    $parts = explode('-', $string);

// The parts will be ["687549", "ot", "1"]
// If you want to get the number after "ot-", that would be the third element in the array
    $number = isset($parts[2]) ? $parts[2] : null;*/

//    echo $number;
    return view('welcome');
});

Route::get('/', function () {

    return view('auth.login');
});

Route::get('/admin', function () {
    return view('admin.index');
});

/*
|--------------------------------------------------------------------------
| Admin Management Routes
|--------------------------------------------------------------------------
*/

//Display all organisation types via API
Route::get('/admin/organisation-types', [OrganisationTypeController::class, 'index'])->name('admin.organisation-types.index');
//Create new organisation types directly
Route::post('/admin/organisation-types/store', [OrganisationTypeController::class, 'store'])->name('admin.organisation-types.store');
//add organisation type of organisation type
Route::post('/admin/organisation-types/{organisationType}', [OrganisationTypeController::class, 'organisationTypeOrganisation'])->name('admin.organisation-types.organisation-type');

//Display all organisations via API
Route::get('/admin/organisations', [OrganisationsController::class, 'index'])->name('admin.organisations.index');
Route::post('/admin/organisations/store', [OrganisationsController::class, 'store'])->name('admin.organisations.store');
Route::patch('/admin/organisations/{organisation}/update', [OrganisationsController::class, 'update'])->name('admin.organisations.update');
Route::delete('/admin/organisations/{organisation}', [OrganisationsController::class, 'destroy'])->name('admin.organisations.destroy');
Route::get('/admin/organisations/manage', [OrganisationsController::class, 'manageOrganisations'])->name('admin.organisations.manage');


//organisation roles routes pass organisation slug
Route::get('/admin/organisation-roles/{organisation}', [OrganisationRolesController::class, 'index'])->name('admin.organisation-roles.index');
Route::post('/admin/organisation-roles/{organisation}/store', [OrganisationRolesController::class, 'store'])->name('admin.organisation-roles.store');
Route::get('/admin/organisation-roles/{role}/edit', [OrganisationRolesController::class, 'edit'])->name('admin.organisation-roles.edit');
Route::patch('/admin/organisation-roles/{role}/update', [OrganisationRolesController::class, 'update'])->name('admin.organisation-roles.update');
Route::delete('/admin/organisation-roles/{role}', [OrganisationRolesController::class, 'destroy'])->name('admin.organisation-roles.destroy');

//routes for organisation users
Route::get('/admin/organisation-users/{organisation}', [OrganisationUsersController::class, 'index'])->name('admin.organisation-users.index');
Route::post('/admin/organisation-users/{organisation}/store', [OrganisationUsersController::class, 'store'])->name('admin.organisation-users.store');
Route::patch('/admin/organisation-users/{user}/update', [OrganisationUsersController::class, 'update'])->name('admin.organisation-users.update');
Route::delete('/admin/organisation-users/{user}/{organisation}', [OrganisationUsersController::class, 'destroy'])->name('admin.organisation-users.destroy');

//routes for species
Route::get('/admin/species', [\App\Http\Controllers\SpeciesController::class, 'index'])->name('admin.species.index');
Route::post('/admin/species/store', [\App\Http\Controllers\SpeciesController::class, 'store'])->name('admin.species.store');
Route::get('/admin/species/{species}/edit', [\App\Http\Controllers\SpeciesController::class, 'edit'])->name('admin.species.edit');
Route::patch('/admin/species/{species}/update', [\App\Http\Controllers\SpeciesController::class, 'update'])->name('admin.species.update');

//routes for species gender
Route::get('/admin/species-gender', [\App\Http\Controllers\SpeciesGenderController::class, 'index'])->name('admin.species-gender.index');
Route::post('/admin/species-gender/store', [\App\Http\Controllers\SpeciesGenderController::class, 'store'])->name('admin.species-gender.store');
Route::get('/admin/species-gender/{speciesGender}/edit', [\App\Http\Controllers\SpeciesGenderController::class, 'edit'])->name('admin.species-gender.edit');
Route::patch('/admin/species-gender/{speciesGender}/update', [\App\Http\Controllers\SpeciesGenderController::class, 'update'])->name('admin.species-gender.update');
Route::delete('/admin/species-gender/{speciesGender}', [\App\Http\Controllers\SpeciesGenderController::class, 'destroy'])->name('admin.species-gender.destroy');

//add maturity routes
Route::get('/admin/maturity', [\App\Http\Controllers\MaturityController::class, 'index'])->name('admin.maturity.index');
Route::post('/admin/maturity/store', [\App\Http\Controllers\MaturityController::class, 'store'])->name('admin.maturity.store');
Route::get('/admin/maturity/{maturity}/edit', [\App\Http\Controllers\MaturityController::class, 'edit'])->name('admin.maturity.edit');
Route::patch('/admin/maturity/{maturity}/update', [\App\Http\Controllers\MaturityController::class, 'update'])->name('admin.maturity.update');

//routes for counting methods
Route::get('/admin/counting-methods', [\App\Http\Controllers\CountingMethodController::class, 'index'])->name('admin.counting-methods.index');
Route::post('/admin/counting-methods/store', [\App\Http\Controllers\CountingMethodController::class, 'store'])->name('admin.counting-methods.store');
Route::get('/admin/counting-methods/{countingMethod}/edit', [\App\Http\Controllers\CountingMethodController::class, 'edit'])->name('admin.counting-methods.edit');
Route::patch('/admin/counting-methods/{countingMethod}/update', [\App\Http\Controllers\CountingMethodController::class, 'update'])->name('admin.counting-methods.update');




/*
|--------------------------------------------------------------------------
| Organisation Dashboard
|--------------------------------------------------------------------------
*/
//organisation dashboard
Route::get('/organisation/dashboard', [\App\Http\Controllers\OrganisationDashboardController::class, 'index'])->name('organisation.dashboard.index')->middleware('auth');

//routes for population estimates for organisation with organisation
Route::get('/{organisation}/population-estimates', [\App\Http\Controllers\PopulationEstimateController::class, 'index'])->name('admin.population-estimates.index');
Route::post('/{organisation}/population-estimates/store', [\App\Http\Controllers\PopulationEstimateController::class, 'store'])->name('admin.population-estimates.store');
Route::get('/{organisation}/population-estimates/{populationEstimate}/edit', [\App\Http\Controllers\PopulationEstimateController::class, 'edit'])->name('admin.population-estimates.edit');
Route::patch('/{organisation}/population-estimates/{populationEstimate}/update', [\App\Http\Controllers\PopulationEstimateController::class, 'update'])->name('admin.population-estimates.update');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
