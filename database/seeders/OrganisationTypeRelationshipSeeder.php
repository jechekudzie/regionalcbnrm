<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrganisationTypeRelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $relationships = [
            ['parent_id' => 1, 'child_id' => 9, 'notes' => 'Media services often involve Entertainment & Performers for coverage.'],
            ['parent_id' => 3, 'child_id' => 7, 'notes' => 'Event Venues often work closely with Event Planning & Coordination services.'],
            ['parent_id' => 5, 'child_id' => 13, 'notes' => 'Catering Services often fall under the broader category of Hospitality & Accommodation.'],
            ['parent_id' => 2, 'child_id' => 12, 'notes' => 'Sound & Audio Equipment is a part of Event Technology Solutions.'],
        ];


        foreach ($relationships as $relation) {
            DB::table('organisation_type_organisation_type')->insert([
                'organisation_type_id' => $relation['parent_id'],
                'child_id' => $relation['child_id'],
                'notes' => $relation['notes'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
