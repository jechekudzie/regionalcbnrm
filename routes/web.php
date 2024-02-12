<?php

use App\Http\Controllers\OrganisationsController;
use App\Http\Controllers\OrganisationRolesController;
use App\Http\Controllers\OrganisationTypeController;
use App\Http\Controllers\OrganisationUsersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Mail;
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


    $string = "800350-ot-5";
    $parts = explode('-', $string);

    $number = isset($parts[2]) ? $parts[2] : null;

    dd($number);
//    echo $number;
    return view('welcome');
});


//organisation r
Route::get('/{organisation}/roles', [\App\Http\Controllers\OrganisationPermissionController::class, 'index'])->name('test.roles.index');


Route::get('/', function () {

    return view('auth.login');
});


/*
|--------------------------------------------------------------------------
| Admin Management Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['role:super-admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');

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

//create permissions
    Route::get('/admin/permissions', [\App\Http\Controllers\PermissionController::class, 'index'])->name('admin.permissions.index');
    Route::post('/admin/permissions/store', [\App\Http\Controllers\PermissionController::class, 'store'])->name('admin.permissions.store');
    Route::get('/admin/permissions/{permission}/edit', [\App\Http\Controllers\PermissionController::class, 'edit'])->name('admin.permissions.edit');
    Route::patch('/admin/permissions/{permission}/update', [\App\Http\Controllers\PermissionController::class, 'update'])->name('admin.permissions.update');
    Route::delete('/admin/permissions/{permission}', [\App\Http\Controllers\PermissionController::class, 'destroy'])->name('admin.permissions.destroy');

//assign permission to organisation roles
    Route::get('/admin/permissions/{organisation}/{role}/assignPermission', [\App\Http\Controllers\PermissionController::class, 'assignPermission'])->name('admin.permissions.assign');
    Route::post('/admin/permissions/{organisation}/{role}/assignPermissionToRole', [\App\Http\Controllers\PermissionController::class, 'assignPermissionToRole'])->name('admin.permissions.assign-permission-to-role');


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
    Route::delete('/admin/maturity/{maturity}', [\App\Http\Controllers\MaturityController::class, 'destroy'])->name('admin.maturity.destroy');


//routes for counting methods
    Route::get('/admin/counting-methods', [\App\Http\Controllers\CountingMethodController::class, 'index'])->name('admin.counting-methods.index');
    Route::post('/admin/counting-methods/store', [\App\Http\Controllers\CountingMethodController::class, 'store'])->name('admin.counting-methods.store');
    Route::get('/admin/counting-methods/{countingMethod}/edit', [\App\Http\Controllers\CountingMethodController::class, 'edit'])->name('admin.counting-methods.edit');
    Route::patch('/admin/counting-methods/{countingMethod}/update', [\App\Http\Controllers\CountingMethodController::class, 'update'])->name('admin.counting-methods.update');
    Route::delete('/admin/counting-methods/{countingMethod}', [\App\Http\Controllers\CountingMethodController::class, 'destroy'])->name('admin.counting-methods.destroy');

//routes for conflict outcomes fields
    Route::get('/admin/conflict-outcomes', [\App\Http\Controllers\ConflictOutComeController::class, 'index'])->name('admin.conflict-outcomes.index');
    Route::post('/admin/conflict-outcomes/store', [\App\Http\Controllers\ConflictOutComeController::class, 'store'])->name('admin.conflict-outcomes.store');
    Route::get('/admin/conflict-outcomes/{ConflictOutCome}/edit', [\App\Http\Controllers\ConflictOutComeController::class, 'edit'])->name('admin.conflict-outcomes.edit');
    Route::patch('/admin/conflict-outcomes/{ConflictOutCome}/update', [\App\Http\Controllers\ConflictOutComeController::class, 'update'])->name('admin.conflict-outcomes.update');
    Route::delete('/admin/conflict-outcomes/{ConflictOutCome}', [\App\Http\Controllers\ConflictOutComeController::class, 'destroy'])->name('admin.conflict-outcomes.destroy');


//routes conflict outcomes  dynamic fields
    Route::get('/admin/conflict-outcomes/{ConflictOutCome}/dynamic-fields', [\App\Http\Controllers\DynamicFieldController::class, 'index'])->name('admin.dynamic-fields.index');
    Route::post('/admin/conflict-outcomes/{ConflictOutCome}/dynamic-fields/store', [\App\Http\Controllers\DynamicFieldController::class, 'store'])->name('admin.dynamic-fields.store');
    Route::get('/admin/conflict-outcomes/{ConflictOutCome}/dynamic-fields/{dynamicField}/edit', [\App\Http\Controllers\DynamicFieldController::class, 'edit'])->name('admin.dynamic-fields.edit');
    Route::patch('/admin/conflict-outcomes/{ConflictOutCome}/dynamic-fields/{dynamicField}/update', [\App\Http\Controllers\DynamicFieldController::class, 'update'])->name('admin.dynamic-fields.update');
    Route::delete('/admin/conflict-outcomes/{ConflictOutCome}/dynamic-fields/{dynamicField}', [\App\Http\Controllers\DynamicFieldController::class, 'destroy'])->name('admin.dynamic-fields.destroy');

//routes conflict outcomes  dynamic fields options
    Route::get('/admin/conflict-outcomes/{ConflictOutCome}/dynamic-fields/{dynamicField}/options', [\App\Http\Controllers\DynamicFieldOptionController::class, 'index'])->name('admin.dynamic-fields-options.index');
    Route::post('/admin/conflict-outcomes/{ConflictOutCome}/dynamic-fields/{dynamicField}/options/store', [\App\Http\Controllers\DynamicFieldOptionController::class, 'store'])->name('admin.dynamic-fields-options.store');
    Route::get('/admin/conflict-outcomes/{ConflictOutCome}/dynamic-fields/{dynamicField}/options/{dynamicFieldOption}/edit', [\App\Http\Controllers\DynamicFieldOptionController::class, 'edit'])->name('admin.dynamic-fields-options.edit');
    Route::patch('/admin/conflict-outcomes/{ConflictOutCome}/dynamic-fields/{dynamicField}/options/{dynamicFieldOption}/update', [\App\Http\Controllers\DynamicFieldOptionController::class, 'update'])->name('admin.dynamic-fields-options.update');
    Route::delete('/admin/conflict-outcomes/{ConflictOutCome}/dynamic-fields/{dynamicField}/options/{dynamicFieldOption}', [\App\Http\Controllers\DynamicFieldOptionController::class, 'destroy'])->name('admin.dynamic-fields-options.destroy');

//conflict types routes
    Route::get('/admin/conflict-types', [\App\Http\Controllers\ConflictTypeController::class, 'index'])->name('admin.conflict-types.index');
    Route::post('/admin/conflict-types/store', [\App\Http\Controllers\ConflictTypeController::class, 'store'])->name('admin.conflict-types.store');
    Route::get('/admin/conflict-types/{conflictType}/edit', [\App\Http\Controllers\ConflictTypeController::class, 'edit'])->name('admin.conflict-types.edit');
    Route::patch('/admin/conflict-types/{conflictType}/update', [\App\Http\Controllers\ConflictTypeController::class, 'update'])->name('admin.conflict-types.update');
    Route::delete('/admin/conflict-types/{conflictType}', [\App\Http\Controllers\ConflictTypeController::class, 'destroy'])->name('admin.conflict-types.destroy');

});


/*
|--------------------------------------------------------------------------
| Organisation Dashboard
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
//organisation dashboard
    Route::get('/organisation/dashboard/check/{organisation}', [\App\Http\Controllers\OrganisationDashboardController::class, 'checkDashboardAccess'])->name('organisation.check-dashboard-access')->middleware('auth');
    Route::get('/organisation/dashboard', [\App\Http\Controllers\OrganisationDashboardController::class, 'dashboard'])->name('organisation.dashboard')->middleware('auth');
    Route::get('/{organisation}/index', [\App\Http\Controllers\OrganisationDashboardController::class, 'index'])->name('organisation.dashboard.index')->middleware('auth');

    Route::get('/rural-district-councils', [\App\Http\Controllers\OrganisationDashboardController::class, 'ruralDistrictCouncils'])->name('organisation.dashboard.rural-district-councils')->middleware('auth');

//wildlife species
    Route::get('/{organisation}/species', [\App\Http\Controllers\OrganisationSpeciesController::class, 'index'])->name('organisation.species.index');

//routes for population estimates for organisation with organisation
    Route::get('/{organisation}/population-estimates', [\App\Http\Controllers\PopulationEstimateController::class, 'species'])->name('organisation.population-estimates.species');
    Route::get('/{organisation}/population-estimates/{species}/index', [\App\Http\Controllers\PopulationEstimateController::class, 'index'])->name('organisation.population-estimates.index');
    Route::get('/{organisation}/population-estimates/by-counting-methods', [\App\Http\Controllers\PopulationEstimateController::class, 'byCountingMethods'])->name('organisation.population-estimates.by-counting-methods');
    Route::post('/{organisation}/population-estimates/store', [\App\Http\Controllers\PopulationEstimateController::class, 'store'])->name('organisation.population-estimates.store');
    Route::get('/{organisation}/population-estimates/{populationEstimate}/edit', [\App\Http\Controllers\PopulationEstimateController::class, 'edit'])->name('organisation.population-estimates.edit');
    Route::patch('/{organisation}/population-estimates/{populationEstimate}/update', [\App\Http\Controllers\PopulationEstimateController::class, 'update'])->name('organisation.population-estimates.update');

//quota settings routes
    Route::get('/{organisation}/quota-settings/species', [\App\Http\Controllers\QuotaSettingController::class, 'species'])->name('organisation.quota-settings.species');
    Route::get('/{organisation}/quota-settings/{species}/index', [\App\Http\Controllers\QuotaSettingController::class, 'index'])->name('organisation.quota-settings.index');
    Route::post('/{organisation}/quota-settings/store', [\App\Http\Controllers\QuotaSettingController::class, 'store'])->name('organisation.quota-settings.store');
    Route::get('/{organisation}/quota-settings/{quotaRequest}/edit', [\App\Http\Controllers\QuotaSettingController::class, 'edit'])->name('organisation.quota-settings.edit');
    Route::patch('/{organisation}/quota-settings/{quotaRequest}/update', [\App\Http\Controllers\QuotaSettingController::class, 'update'])->name('organisation.quota-settings.update');

//routes for WardQuotaDistributionC for a quota request
    Route::get('/{organisation}/quota-settings/{quotaRequest}/ward-quota-distribution', [\App\Http\Controllers\WardQuotaDistributionController::class, 'index'])->name('organisation.ward-quota-distribution.index');
    Route::post('/{organisation}/quota-settings/{quotaRequest}/ward-quota-distribution/store', [\App\Http\Controllers\WardQuotaDistributionController::class, 'store'])->name('organisation.ward-quota-distribution.store');
    Route::get('/{organisation}/quota-settings/{quotaRequest}/ward-quota-distribution/{wardQuotaDistribution}/edit', [\App\Http\Controllers\WardQuotaDistributionController::class, 'edit'])->name('organisation.ward-quota-distribution.edit');
    Route::patch('/{organisation}/quota-settings/{quotaRequest}/ward-quota-distribution/{wardQuotaDistribution}/update', [\App\Http\Controllers\WardQuotaDistributionController::class, 'update'])->name('organisation.ward-quota-distribution.update');
    Route::delete('/{organisation}/quota-settings/{quotaRequest}/ward-quota-distribution/{wardQuotaDistribution}', [\App\Http\Controllers\WardQuotaDistributionController::class, 'destroy'])->name('organisation.ward-quota-distribution.destroy');


//hunting concession routes
    Route::get('/{organisation}/hunting-concessions', [\App\Http\Controllers\HuntingConcessionController::class, 'index'])->name('organisation.hunting-concessions.index');
    Route::get('/{organisation}/hunting-concessions/create', [\App\Http\Controllers\HuntingConcessionController::class, 'create'])->name('organisation.hunting-concessions.create');
    Route::post('/{organisation}/hunting-concessions/store', [\App\Http\Controllers\HuntingConcessionController::class, 'store'])->name('organisation.hunting-concessions.store');
    Route::get('/{organisation}/hunting-concessions/{huntingConcession}/edit', [\App\Http\Controllers\HuntingConcessionController::class, 'edit'])->name('organisation.hunting-concessions.edit');
    Route::patch('/{organisation}/hunting-concessions/{huntingConcession}/update', [\App\Http\Controllers\HuntingConcessionController::class, 'update'])->name('organisation.hunting-concessions.update');
    Route::delete('/{organisation}/hunting-concessions/{huntingConcession}', [\App\Http\Controllers\HuntingConcessionController::class, 'destroy'])->name('organisation.hunting-concessions.destroy');


//hunter controller
    Route::get('/{organisation}/hunters', [\App\Http\Controllers\HunterController::class, 'index'])->name('organisation.hunters.index');
//create, store, edit, update, destroy
    Route::get('/{organisation}/hunters/create', [\App\Http\Controllers\HunterController::class, 'create'])->name('organisation.hunters.create');
    Route::post('/{organisation}/hunters/store', [\App\Http\Controllers\HunterController::class, 'store'])->name('organisation.hunters.store');
    Route::get('/{organisation}/hunters/{hunter}/edit', [\App\Http\Controllers\HunterController::class, 'edit'])->name('organisation.hunters.edit');
    Route::patch('/{organisation}/hunters/{hunter}/update', [\App\Http\Controllers\HunterController::class, 'update'])->name('organisation.hunters.update');
    Route::delete('/{organisation}/hunters/{hunter}', [\App\Http\Controllers\HunterController::class, 'destroy'])->name('organisation.hunters.destroy');


//need routes for organisation.safari-license
    Route::get('/{organisation}/safari-licenses', [\App\Http\Controllers\HuntingLicenseController::class, 'index'])->name('organisation.safari-licenses.index');
//give create, store, edit, update and delete routes
    Route::get('/{organisation}/safari-licenses/create', [\App\Http\Controllers\HuntingLicenseController::class, 'create'])->name('organisation.safari-licenses.create');
    Route::post('/{organisation}/safari-licenses/store', [\App\Http\Controllers\HuntingLicenseController::class, 'store'])->name('organisation.safari-licenses.store');
    Route::get('/{organisation}/safari-licenses/{huntingLicense}/edit', [\App\Http\Controllers\HuntingLicenseController::class, 'edit'])->name('organisation.safari-licenses.edit');
    Route::patch('/{organisation}/safari-licenses/{huntingLicense}/update', [\App\Http\Controllers\HuntingLicenseController::class, 'update'])->name('organisation.safari-licenses.update');
    Route::delete('/{organisation}/safari-licenses/{huntingLicense}', [\App\Http\Controllers\HuntingLicenseController::class, 'destroy'])->name('organisation.safari-licenses.destroy');


//need routes for organisation.hunting-activity
    Route::get('/{organisation}/hunting-activities', [\App\Http\Controllers\HuntingActivityController::class, 'index'])->name('organisation.hunting-activities.index');
    Route::get('/{organisation}/hunting-activities/create', [\App\Http\Controllers\HuntingActivityController::class, 'create'])->name('organisation.hunting-activities.create');
    Route::post('/{organisation}/hunting-activities/store', [\App\Http\Controllers\HuntingActivityController::class, 'store'])->name('organisation.hunting-activities.store');
    Route::get('/{organisation}/hunting-activities/{huntingActivity}/edit', [\App\Http\Controllers\HuntingActivityController::class, 'edit'])->name('organisation.hunting-activities.edit');
    Route::patch('/{organisation}/hunting-activities/{huntingActivity}/update', [\App\Http\Controllers\HuntingActivityController::class, 'update'])->name('organisation.hunting-activities.update');
    Route::delete('/{organisation}/hunting-activities/{huntingActivity}', [\App\Http\Controllers\HuntingActivityController::class, 'destroy'])->name('organisation.hunting-activities.destroy');
    Route::get('/{organisation}/hunting-activities/{huntingActivity}', [\App\Http\Controllers\HuntingActivityController::class, 'show'])->name('organisation.hunting-activities.show');
//add hunter client
    Route::get('/{organisation}/hunting-activities/{huntingActivity}/add-hunter-client', [\App\Http\Controllers\HuntingActivityController::class, 'addHunterClient'])->name('organisation.hunting-activities.add-hunter-client');
    Route::post('/{organisation}/hunting-activities/{huntingActivity}/save-hunter-client', [\App\Http\Controllers\HuntingActivityController::class, 'saveHunterClient'])->name('organisation.hunting-activities.save-hunter-client');
    Route::post('/{organisation}/hunting-activities/{huntingActivity}/save-new-hunter-client', [\App\Http\Controllers\HuntingActivityController::class, 'saveNewHunterClient'])->name('organisation.hunting-activities.save-new-hunter-client');
//hunting vehicles
    Route::get('/{organisation}/hunting-activities/{huntingActivity}/add-hunting-vehicles', [\App\Http\Controllers\HuntingActivityController::class, 'addHuntingVehicles'])->name('organisation.hunting-activities.add-hunting-vehicles');
    Route::post('/{organisation}/hunting-activities/{huntingActivity}/save-hunting-vehicles', [\App\Http\Controllers\HuntingActivityController::class, 'saveHuntingVehicles'])->name('organisation.hunting-activities.save-hunting-vehicles');
    Route::patch('/{organisation}/hunting-activities/{huntingActivityVehicle}/update-hunting-vehicles', [\App\Http\Controllers\HuntingActivityController::class, 'updateHuntingVehicles'])->name('organisation.hunting-activities.update-hunting-vehicles');
    Route::delete('/{organisation}/hunting-activities/{huntingActivityVehicle}/delete-hunting-vehicles', [\App\Http\Controllers\HuntingActivityController::class, 'deleteHuntingVehicles'])->name('organisation.hunting-activities.delete-hunting-vehicles');

//species details
    Route::get('/{organisation}/hunting-activities/{huntingActivity}/species-details', [\App\Http\Controllers\HuntingDetailsController::class, 'index'])->name('organisation.hunting-activities.species-details');
    Route::post('/{organisation}/hunting-activities/{huntingActivity}/save-species-details', [\App\Http\Controllers\HuntingDetailsController::class, 'store'])->name('organisation.hunting-activities.save-species-details');
    Route::get('/{organisation}/hunting-activities/{huntingDetail}/edit-species-details', [\App\Http\Controllers\HuntingDetailsController::class, 'editSpeciesDetails'])->name('organisation.hunting-activities.edit-species-details');
    Route::patch('/{organisation}/hunting-activities/{huntingDetail}/update-species-details', [\App\Http\Controllers\HuntingDetailsController::class, 'updateSpeciesDetails'])->name('organisation.hunting-activities.update-species-details');
    Route::delete('/{organisation}/hunting-activities/{huntingDetail}/delete-species-details', [\App\Http\Controllers\HuntingDetailsController::class, 'deleteSpeciesDetails'])->name('organisation.hunting-activities.delete-species-details');

//hunting detail outcomes
    Route::get('/{organisation}/hunting-activities/{huntingDetail}/hunting-outcomes', [\App\Http\Controllers\HuntingDetailOutComeController::class, 'index'])->name('organisation.hunting-detail-outcome.index');
    Route::post('/{organisation}/hunting-activities/{huntingDetail}/hunting-outcomes/store', [\App\Http\Controllers\HuntingDetailOutComeController::class, 'store'])->name('organisation.hunting-detail-outcome.store');
    Route::get('/{organisation}/hunting-activities/hunting-outcomes/{huntingDetailOutCome}/edit', [\App\Http\Controllers\HuntingDetailOutComeController::class, 'edit'])->name('organisation.hunting-detail-outcome.edit');
    Route::patch('/{organisation}/hunting-activities/hunting-outcomes/{huntingDetailOutCome}/update', [\App\Http\Controllers\HuntingDetailOutComeController::class, 'update'])->name('organisation.hunting-detail-outcome.update');
    Route::delete('/{organisation}/hunting-activities/hunting-outcomes/{huntingDetailOutCome}', [\App\Http\Controllers\HuntingDetailOutComeController::class, 'destroy'])->name('organisation.hunting-detail-outcome.destroy');


//HWC incident routes
    Route::get('/{organisation}/incidents', [\App\Http\Controllers\IncidentController::class, 'index'])->name('organisation.incidents.index');
    Route::get('/{organisation}/incidents/create', [\App\Http\Controllers\IncidentController::class, 'create'])->name('organisation.incidents.create');
    Route::post('/{organisation}/incidents/store', [\App\Http\Controllers\IncidentController::class, 'store'])->name('organisation.incidents.store');
    Route::get('/{organisation}/incidents/{incident}/edit', [\App\Http\Controllers\IncidentController::class, 'edit'])->name('organisation.incidents.edit');
    Route::patch('/{organisation}/incidents/{incident}/update', [\App\Http\Controllers\IncidentController::class, 'update'])->name('organisation.incidents.update');
    Route::delete('/{organisation}/incidents/{incident}', [\App\Http\Controllers\IncidentController::class, 'destroy'])->name('organisation.incidents.destroy');


//incident species routes
    Route::get('/{organisation}/incidents/{incident}/species', [\App\Http\Controllers\IncidentSpeciesController::class, 'index'])->name('organisation.incident-species.index');
    Route::post('/{organisation}/incidents/{incident}/species/store', [\App\Http\Controllers\IncidentSpeciesController::class, 'store'])->name('organisation.incident-species.store');
    Route::get('/{organisation}/incidents/{incident}/species/{incidentSpecies}/edit', [\App\Http\Controllers\IncidentSpeciesController::class, 'edit'])->name('organisation.incident-species.edit');
    Route::patch('/{organisation}/incidents/{incident}/species/{incidentSpecies}/update', [\App\Http\Controllers\IncidentSpeciesController::class, 'update'])->name('organisation.incident-species.update');
    Route::delete('/{organisation}/incidents/{incident}/species/{incidentSpecies}', [\App\Http\Controllers\IncidentSpeciesController::class, 'destroy'])->name('organisation.incident-species.destroy');


//incident conflict types routes
    Route::get('/{organisation}/incidents/{incident}/conflict-types', [\App\Http\Controllers\IncidentConflictTypeController::class, 'index'])->name('organisation.incident-conflict-types.index');
    Route::post('/{organisation}/incidents/{incident}/conflict-types/store', [\App\Http\Controllers\IncidentConflictTypeController::class, 'store'])->name('organisation.incident-conflict-types.store');
    Route::get('/{organisation}/incidents/{incident}/conflict-types/{incidentConflictType}/edit', [\App\Http\Controllers\IncidentConflictTypeController::class, 'edit'])->name('organisation.incident-conflict-types.edit');
    Route::patch('/{organisation}/incidents/{incident}/conflict-types/{incidentConflictType}/update', [\App\Http\Controllers\IncidentConflictTypeController::class, 'update'])->name('organisation.incident-conflict-types.update');
    Route::delete('/{organisation}/incidents/{incident}/conflict-types/{incidentConflictType}', [\App\Http\Controllers\IncidentConflictTypeController::class, 'destroy'])->name('organisation.incident-conflict-types.destroy');

//incident outcomes
    Route::get('/{organisation}/incidents/{incident}/outcomes', [\App\Http\Controllers\IncidentOutcomeController::class, 'index'])->name('organisation.incident-outcomes.index');
    Route::post('/{organisation}/incidents/{incident}/outcomes/store', [\App\Http\Controllers\IncidentOutcomeController::class, 'store'])->name('organisation.incident-outcomes.store');
    Route::get('/{organisation}/incidents/{incident}/outcomes/{incidentOutcome}/edit', [\App\Http\Controllers\IncidentOutcomeController::class, 'edit'])->name('organisation.incident-outcomes.edit');
    Route::patch('/{organisation}/incidents/{incident}/outcomes/{incidentOutcome}/update', [\App\Http\Controllers\IncidentOutcomeController::class, 'update'])->name('organisation.incident-outcomes.update');
    Route::delete('/{organisation}/incidents/{incident}/outcomes/{incidentOutcome}', [\App\Http\Controllers\IncidentOutcomeController::class, 'destroy'])->name('organisation.incident-outcomes.destroy');

//incident conflict outcome dynamic fields
    Route::get('/{organisation}/incidents/{incident}/outcomes/{incidentOutCome}/dynamic-fields', [\App\Http\Controllers\IncidentOutcomeDynamicFieldController::class, 'index'])->name('organisation.incident-outcomes-dynamic-fields.index');
    Route::post('/{organisation}/incidents/{incident}/outcomes/{incidentOutCome}/dynamic-fields/store', [\App\Http\Controllers\IncidentOutcomeDynamicFieldController::class, 'store'])->name('organisation.incident-outcomes-dynamic-fields.store');
    Route::get('/{organisation}/incidents/{incident}/outcomes/{incidentOutCome}/dynamic-fields/{incidentOutcomeDynamicField}/edit', [\App\Http\Controllers\IncidentOutcomeDynamicFieldController::class, 'edit'])->name('organisation.incident-outcomes-dynamic-fields.edit');
    Route::patch('/{organisation}/incidents/{incident}/outcomes/{incidentOutCome}/dynamic-fields/{incidentOutcomeDynamicField}/update', [\App\Http\Controllers\IncidentOutcomeDynamicFieldController::class, 'update'])->name('organisation.incident-outcomes-dynamic-fields.update');
    Route::delete('/{organisation}/incidents/{incident}/outcomes/{incidentOutCome}/dynamic-fields/{incidentOutcomeDynamicField}', [\App\Http\Controllers\IncidentOutcomeDynamicFieldController::class, 'destroy'])->name('organisation.incident-outcomes-dynamic-fields.destroy');

//routes for poaching incidents
    Route::get('/{organisation}/poaching-incidents', [\App\Http\Controllers\PoachingIncidentController::class, 'index'])->name('organisation.poaching-incidents.index');
    Route::get('/{organisation}/poaching-incidents/create', [\App\Http\Controllers\PoachingIncidentController::class, 'create'])->name('organisation.poaching-incidents.create');
    Route::post('/{organisation}/poaching-incidents/store', [\App\Http\Controllers\PoachingIncidentController::class, 'store'])->name('organisation.poaching-incidents.store');
    Route::get('/{organisation}/poaching-incidents/{poachingIncident}/edit', [\App\Http\Controllers\PoachingIncidentController::class, 'edit'])->name('organisation.poaching-incidents.edit');
    Route::patch('/{organisation}/poaching-incidents/{poachingIncident}/update', [\App\Http\Controllers\PoachingIncidentController::class, 'update'])->name('organisation.poaching-incidents.update');
    Route::delete('/{organisation}/poaching-incidents/{poachingIncident}', [\App\Http\Controllers\PoachingIncidentController::class, 'destroy'])->name('organisation.poaching-incidents.destroy');

//poaching incident species
    Route::get('/{organisation}/poaching-incidents/{poachingIncident}/species', [\App\Http\Controllers\PoachingIncidentSpeciesController::class, 'index'])->name('organisation.poaching-incident-species.index');
    Route::post('/{organisation}/poaching-incidents/{poachingIncident}/species/store', [\App\Http\Controllers\PoachingIncidentSpeciesController::class, 'store'])->name('organisation.poaching-incident-species.store');
    Route::get('/{organisation}/poaching-incidents/{poachingIncident}/species/{poachingIncidentSpecies}/edit', [\App\Http\Controllers\PoachingIncidentSpeciesController::class, 'edit'])->name('organisation.poaching-incident-species.edit');
    Route::patch('/{organisation}/poaching-incidents/{poachingIncident}/species/{poachingIncidentSpecies}/update', [\App\Http\Controllers\PoachingIncidentSpeciesController::class, 'update'])->name('organisation.poaching-incident-species.update');
    Route::delete('/{organisation}/poaching-incidents/{poachingIncident}/species/{poachingIncidentSpecies}', [\App\Http\Controllers\PoachingIncidentSpeciesController::class, 'destroy'])->name('organisation.poaching-incident-species.destroy');

    //organisation create
    Route::get('/{organisation}/organisations/{organisationType}/index', [\App\Http\Controllers\OrganisationChildrenController::class, 'index'])->name('organisation.organisations.index');
    Route::post('/{organisation}/organisations/{organisationType}/store', [\App\Http\Controllers\OrganisationChildrenController::class, 'store'])->name('organisation.organisations.store');
    Route::get('/{organisation}/organisations/{organisationType}/edit', [\App\Http\Controllers\OrganisationChildrenController::class, 'edit'])->name('organisation.organisations.edit');
    Route::patch('/{organisation}/organisations/{organisationToUpdate}/update', [\App\Http\Controllers\OrganisationChildrenController::class, 'update'])->name('organisation.organisations.update');
    Route::delete('/{organisation}/organisations/{organisationToDelete}', [\App\Http\Controllers\OrganisationChildrenController::class, 'destroy'])->name('organisation.organisations.destroy');
});

Route::get('/send-test-emails', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('nigel@leadingdigital.africa')->subject('Test Email');
    });
    return 'Test email sent';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
