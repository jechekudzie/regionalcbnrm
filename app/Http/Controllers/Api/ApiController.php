<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hunter;
use App\Models\HuntingDetailOutCome;
use App\Models\Organisation;
use App\Models\OrganisationType;
use App\Models\QuotaRequest;
use App\Models\Species;
use App\Models\User;
use App\Models\WardQuotaDistribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ApiController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | Organisation Management
     |--------------------------------------------------------------------------
     */
    private $generatedNumbers = [];

    public function fetchTemplate()
    {
        $organisations = OrganisationType::whereDoesntHave('parents')->get();
        $data = $this->formatTreeData($organisations);
        return response()->json($data);
    }

    private function formatTreeData($organisations)
    {
        $data = [];

        foreach ($organisations as $organisation) {

            $data[] = [
                'id' => $organisation->id,
                'text' => $organisation->name,
                'slug' => $organisation->slug,
                'children' => $this->formatTreeData($organisation->children),
            ];

        }
        return $data;
    }

    function generateUniqueNumber($min, $max)
    {
        $num = rand($min, $max);
        while (in_array($num, $this->generatedNumbers)) {
            $num = rand($min, $max);
        }
        $this->generatedNumbers[] = $num;
        return $num;
    }

    public function fetchOrganisationInstances()
    {
        $organisations = OrganisationType::whereDoesntHave('parents')->get();
        $data = [];

        foreach ($organisations as $organisation) {
            //random number
            $rand = $this->generateUniqueNumber(1, 1000000);

            $data[] = [
                'id' => $rand . '-ot-' . $organisation->id,
                'text' => $organisation->name,
                'type' => 'organisationType',
                'type_id' => $organisation->id,
                'slug' => $organisation->slug,
                'parentId' => null, // Set parent ID to null for top-level Organisation Types
                'parentName' => null,
                'children' => $this->formatOrganisationTreeData($organisation->organisations()->get()),
            ];
        }

        return response()->json($data);
    }

    private function formatOrganisationTreeData($entities, $parentOrganisationId = null, $parentOrganisationName = null)
    {
        $data = [];

        foreach ($entities as $entity) {
            //random number
            $rand = $this->generateUniqueNumber(1, 1000000);

            if ($entity instanceof Organisation) {

                $data[] = [
                    'id' => $rand . '-o-' . $entity->id,
                    'text' => $entity->name,
                    'type' => 'organisation',
                    'type_id' => $entity->organisation_type_id,
                    'slug' => $entity->slug,
                    'parentId' => $parentId = $entity->parentOrganisation ? $rand . '-o-' . $entity->parentOrganisation->id : null, // Set parent ID to organisation parent
                    'parentName' => $entity->parentOrganisation->name ?? null, //fetch using parentOrganisation method in Organisation model
                    // Process children OrganisationTypes, passing current Organisation as parent
                    'children' => $this->formatOrganisationTreeData($entity->organisationType->children, $rand . '-o-' . $entity->id, $entity->name),
                ];
            } else {

                $parts = explode('-', $parentOrganisationId);
                $organisation_id = $parts[2] ?? null;

                $data[] = [
                    'id' => $rand . '-ot-' . $entity->id,
                    'text' => $entity->name,
                    'type' => 'organisationType',
                    'type_id' => $entity->id,
                    'parentId' => $parentOrganisationId, // Inherit parent ID from the Organisation above
                    'parentName' => $parentOrganisationName, // Inherit parent name from the Organisation above
                    // Process child Organisations, maintaining current OrganisationType as parent
                    'children' => $this->formatOrganisationTreeData($entity->organisations()->where('organisation_id', $organisation_id)->get(), $rand . '-ot-' . $entity->id, $entity->name),
                ];
            }
        }
        return $data;
    }

    //fetchOrganisation via API
    public function fetchOrganisation(Organisation $organisation)
    {
        //return json response
        return response()->json($organisation);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $hunters = Hunter::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('mobile_number', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
            ->with('country')
            ->get();

        return response()->json($hunters);
    }

    //fetchHuntingConcessionsByRuralDistrictCouncil
    public function fetchHuntingConcessionsByRuralDistrictCouncil(Request $request, $ruralDistrictCouncilId)
    {
        $ruralDistrictCouncil = Organisation::find($ruralDistrictCouncilId);
        $huntingConcessions = DB::table('hunting_concessions')
            ->where('organisation_id', $ruralDistrictCouncil->id)
            ->get();
        return response()->json($huntingConcessions);
    }

    //fetchSpecies
    public function fetchSpecies(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'year' => 'required|integer',
            'huntingConcessionId' => 'required|integer',
        ]);

        // Retrieve species data for the specified year and hunting concession
        $speciesData = Species::whereHas('quotaRequests', function ($query) use ($request) {
            $query->where('year', $request->input('year'))
                ->where('hunting_concession_id', $request->input('huntingConcessionId'));
        })->get();

        // Return the species data as a JSON response
        return response()->json($speciesData);
    }

    public function fetchWardQuotaDistributions(Request $request)
    {
        $year = $request->input('year');
        $huntingConcessionId = $request->input('huntingConcessionId');

        // Retrieve ward IDs covered by the specified hunting concession
        $wardIds = DB::table('hunting_concession_ward')
            ->where('hunting_concession_id', $huntingConcessionId)
            ->pluck('ward_id');

        // Fetch and aggregate quota distributions for these wards
        $quotaDistributions = WardQuotaDistribution::with(['quotaRequest.species'])
            ->whereIn('ward_id', $wardIds)
            ->whereHas('quotaRequest', function ($query) use ($year) {
                $query->where('year', $year);
            })
            ->get()
            ->groupBy('quotaRequest.species_id') // Group by species_id
            ->map(function ($groupedDistributions) {
                // Sum up quotas for each species group
                return [
                    'species_name' => $groupedDistributions->first()->quotaRequest->species->name,
                    'hunting_quota' => $groupedDistributions->sum('hunting_quota'),
                    'species_id' => $groupedDistributions->first()->quotaRequest->species_id,
                    'is_special' => $groupedDistributions->first()->quotaRequest->species->is_special ?? 0,
                    'quota_request_id' => $groupedDistributions->first()->quotaRequest->id,
                ];
            })->values(); // Convert the collection to a plain array

        return response()->json($quotaDistributions);
    }



    public function getPicturesBySlug(Request $request, HuntingDetailOutCome $huntingDetailOutCome)
    {
        // Fetch the HuntingDetailOutcome by slug

        // Decode the JSON pictures field into an array
        $pictures = json_decode($huntingDetailOutCome->pictures, true);

        // Return the pictures as a JSON response
        return response()->json(['pictures' => $pictures]);
    }
}
