<?php

namespace Database\Seeders;

use App\Models\OrganisationType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $organisationTypes = [

            ['name' => 'System users', 'slug' => 'system-users', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Funders', 'slug' => 'funders', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Developers', 'slug' => 'developers', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Zimbabwe template', 'slug' => 'zimbabwe-template', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Rural District Council', 'slug' => 'rural-district-council', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Wildlife Management Authority', 'slug' => 'zimbabwe-parks-wildlife-management-authority', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'NGOs', 'slug' => 'ngos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Wards', 'slug' => 'wards', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Campfire Committee', 'slug' => 'campfire-committee', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Villages', 'slug' => 'villages', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Zimparks Stations', 'slug' => 'zimparks-stations', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Associations', 'slug' => 'associations', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Safari Operators', 'slug' => 'safari-operator', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

        ];

        foreach ($organisationTypes as $type) {
            OrganisationType::create($type);
        }

    }
}
