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
        ];

        foreach ($organisations as $organisation) {
            Organisation::create($organisation);
        }
    }
}
