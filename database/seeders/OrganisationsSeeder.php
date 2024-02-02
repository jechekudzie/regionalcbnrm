<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;


class OrganisationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $organisations = [
            ['name' => 'Regional CBNRM', 'organisation_type_id' => 1, 'organisation_id' => null, 'slug' => 'regional-cbnrm', 'created_at' => Carbon::parse('2024-01-28 08:03:49'), 'updated_at' => Carbon::parse('2024-01-28 08:03:49')],
            ['name' => 'Resource Africa', 'organisation_type_id' => 2, 'organisation_id' => 1, 'slug' => 'resource-africa', 'created_at' => Carbon::parse('2024-01-28 08:04:18'), 'updated_at' => Carbon::parse('2024-01-28 08:04:18')],
            ['name' => 'Jamma International', 'organisation_type_id' => 2, 'organisation_id' => 1, 'slug' => 'jamma-international', 'created_at' => Carbon::parse('2024-01-28 08:04:32'), 'updated_at' => Carbon::parse('2024-01-28 08:04:32')],
            ['name' => 'Leading Digital', 'organisation_type_id' => 3, 'organisation_id' => 1, 'slug' => 'leading-digital', 'created_at' => Carbon::parse('2024-01-28 08:04:40'), 'updated_at' => Carbon::parse('2024-01-28 08:04:40')],
            ['name' => 'Zimbabwe', 'organisation_type_id' => 4, 'organisation_id' => 1, 'slug' => 'zimbabwe', 'created_at' => Carbon::parse('2024-01-28 08:04:51'), 'updated_at' => Carbon::parse('2024-01-28 08:04:51')],
            ['name' => 'Beitbridge', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'beitbridge', 'created_at' => Carbon::parse('2024-02-02 01:24:17'), 'updated_at' => Carbon::parse('2024-02-02 01:24:17')],
            ['name' => 'Binga', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'binga', 'created_at' => Carbon::parse('2024-02-02 01:24:25'), 'updated_at' => Carbon::parse('2024-02-02 01:24:25')],
            ['name' => 'Bulilima', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'bulilima', 'created_at' => Carbon::parse('2024-02-02 01:24:31'), 'updated_at' => Carbon::parse('2024-02-02 01:24:31')],
            ['name' => 'Bubi', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'bubi', 'created_at' => Carbon::parse('2024-02-02 01:24:39'), 'updated_at' => Carbon::parse('2024-02-02 01:24:39')],
            ['name' => 'Chipinge', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'chipinge', 'created_at' => Carbon::parse('2024-02-02 01:24:43'), 'updated_at' => Carbon::parse('2024-02-02 01:24:43')],
            ['name' => 'Chiredzi', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'chiredzi', 'created_at' => Carbon::parse('2024-02-02 01:24:48'), 'updated_at' => Carbon::parse('2024-02-02 01:24:48')],
            ['name' => 'Gokwe North', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'gokwe-north', 'created_at' => Carbon::parse('2024-02-02 01:24:54'), 'updated_at' => Carbon::parse('2024-02-02 01:24:54')],
            ['name' => 'Gokwe South', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'gokwe-south', 'created_at' => Carbon::parse('2024-02-02 01:25:01'), 'updated_at' => Carbon::parse('2024-02-02 01:25:01')],
            ['name' => 'Hurungwe', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'hurungwe', 'created_at' => Carbon::parse('2024-02-02 01:25:10'), 'updated_at' => Carbon::parse('2024-02-02 01:25:10')],
            ['name' => 'Hwange', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'hwange', 'created_at' => Carbon::parse('2024-02-02 01:25:15'), 'updated_at' => Carbon::parse('2024-02-02 01:25:15')],
            ['name' => 'Uzumba Maramba Pfungwe (UMP)', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'uzumba-maramba-pfungwe-ump', 'created_at' => Carbon::parse('2024-02-02 01:26:09'), 'updated_at' => Carbon::parse('2024-02-02 01:26:09')],
            ['name' => 'Umguza', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'umguza', 'created_at' => Carbon::parse('2024-02-02 01:26:15'), 'updated_at' => Carbon::parse('2024-02-02 01:26:15')],
            ['name' => 'Mangwe', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'mangwe', 'created_at' => Carbon::parse('2024-02-02 01:26:20'), 'updated_at' => Carbon::parse('2024-02-02 01:26:20')],
            ['name' => 'Mbire', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'mbire', 'created_at' => Carbon::parse('2024-02-02 01:26:30'), 'updated_at' => Carbon::parse('2024-02-02 01:26:30')],
            ['name' => 'Nyaminyami', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'nyaminyami', 'created_at' => Carbon::parse('2024-02-02 01:26:35'), 'updated_at' => Carbon::parse('2024-02-02 01:26:35')],
            ['name' => 'Tsholotsho', 'organisation_type_id' => 5, 'organisation_id' => 5, 'slug' => 'tsholotsho', 'created_at' => Carbon::parse('2024-02-02 01:26:42'), 'updated_at' => Carbon::parse('2024-02-02 01:26:42')],
            ['name' => 'Campfire Association', 'organisation_type_id' => 12, 'organisation_id' => 5, 'slug' => 'campfire-association', 'created_at' => Carbon::parse('2024-02-02 01:26:42'), 'updated_at' => Carbon::parse('2024-02-02 01:26:42')]
        ];

        foreach ($organisations as $organisation) {

            $newOrganisation = Organisation::create($organisation);

            // Create admin role
            $newOrganisation->organisationRoles()->create([
                'name' => 'admin',
                'guard_name' => 'web',
            ]);

        }
    }
}
