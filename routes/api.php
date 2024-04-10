<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/test-data', [\App\Http\Controllers\TestController::class, 'index'])->name('test.roles.index');

// Define the route for getting location information based on latitude and longitude
Route::get('/get-location', function (Request $request) {
    $latitude = $request->query('lat');
    $longitude = $request->query('lon');

    // Ensure latitude and longitude are provided
    if (!$latitude || !$longitude) {
        return response()->json(['error' => 'Latitude and Longitude are required.'], 400);
    }

    // Call the Nominatim API for reverse geocoding
    $response = Http::withHeaders([
        'User-Agent' => 'YourAppName/1.0 (YourContactEmail@example.com)'
    ])->get('https://nominatim.openstreetmap.org/reverse', [
        'format' => 'json',
        'lat' => $latitude,
        'lon' => $longitude,
        'zoom' => 18, // Adjust for desired detail level
        'addressdetails' => 1,
    ]);

    // Check if the request was successful and return the data
    if ($response->successful()) {
        $data = $response->json();
        return response()->json([
            'address' => $data['display_name'] ?? 'Address not found',
            'lat' => $latitude,
            'lon' => $longitude,
        ]);
    }

    // Handle errors or unsuccessful requests
    return response()->json(['error' => 'Failed to retrieve location information'], 500);
})->name('get-location');

//organisation types
Route::get('/admin/organisation-types', [ApiController::class, 'fetchTemplate'])->name('admin.organisation-types.index');
//organisations
Route::get('/admin/organisations', [ApiController::class, 'fetchOrganisationInstances'])->name('admin.organisations.index');
//organisation
Route::get('/admin/organisations/{organisation}/edit', [ApiController::class, 'fetchOrganisation'])->name('admin.organisations.edit');

//route to search hunters
Route::get('/hunters/search', [ApiController::class, 'search'])->name('admin.hunters.index');

//get-concessions-by-rdc
Route::get('/get-concessions-by-rdc/{ruralDistrictCouncilId}', [ApiController::class, 'fetchHuntingConcessionsByRuralDistrictCouncil'])->name('admin.rural-district-councils.hunting-concessions.index');

//fetch-species
Route::get('/fetch-quota-requests', [ApiController::class, 'fetchQuotaRequests'])->name('fetch-species.index');

Route::get('/fetch-ward-quota-distributions', [ApiController::class, 'fetchWardQuotaDistributions'])->name('fetch-ward-quota-distributions.index');

Route::get('/fetch-species-for-quota', [ApiController::class, 'fetchSpeciesForQuota'])->name('fetch-species-for-quota');

Route::get('/hunting-outcomes/pictures/{huntingDetailOutCome}', [ApiController::class, 'getPicturesBySlug']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
