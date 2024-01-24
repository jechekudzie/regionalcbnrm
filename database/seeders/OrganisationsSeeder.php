<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Define an array of 10 dummy organizations with their details
        $organizations = [
            [
                'organisation_type_id' => 1,
                'organisation_id' => null,
                'name' => 'Organization 1',
                'logo' => 'logo1.jpg',
                'description' => 'Description of Organization 1.',
            ],
            [
                'organisation_type_id' => 2,
                'organisation_id' => null,
                'name' => 'Organization 2',
                'logo' => 'logo2.jpg',
                'description' => 'Description of Organization 2.',
            ],
            [
                'organisation_type_id' => 2,
                'organisation_id' => 1,
                'name' => 'Suborganization 1',
                'logo' => 'sublogo1.jpg',
                'description' => 'Description of Suborganization 1.',
            ],
            [
                'organisation_type_id' => 3,
                'organisation_id' => null,
                'name' => 'Organization 3',
                'logo' => 'logo3.jpg',
                'description' => 'Description of Organization 3.',
            ],
            [
                'organisation_type_id' => 4,
                'organisation_id' => null,
                'name' => 'Organization 4',
                'logo' => 'logo4.jpg',
                'description' => 'Description of Organization 4.',
            ],
            [
                'organisation_type_id' => 5,
                'organisation_id' => null,
                'name' => 'Organization 5',
                'logo' => 'logo5.jpg',
                'description' => 'Description of Organization 5.',
            ],
            [
                'organisation_type_id' => 3,
                'organisation_id' => 2,
                'name' => 'Suborganization 2',
                'logo' => 'sublogo2.jpg',
                'description' => 'Description of Suborganization 2.',
            ],
            [
                'organisation_type_id' => 6,
                'organisation_id' => null,
                'name' => 'Organization 6',
                'logo' => 'logo6.jpg',
                'description' => 'Description of Organization 6.',
            ],
            [
                'organisation_type_id' => 7,
                'organisation_id' => null,
                'name' => 'Organization 7',
                'logo' => 'logo7.jpg',
                'description' => 'Description of Organization 7.',
            ],
            [
                'organisation_type_id' => 8,
                'organisation_id' => null,
                'name' => 'Organization 8',
                'logo' => 'logo8.jpg',
                'description' => 'Description of Organization 8.',
            ],
        ];

        // Loop through the organizations array and insert them into the 'organisations' table
        foreach ($organizations as $organizationData) {
            Organisation::create($organizationData);
        }
    }
}
