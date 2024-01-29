<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            OrganisationTypesSeeder::class,
            OrganisationTypeRelationshipSeeder::class,
            OrganisationsSeeder::class,
            SpeciesSeeder::class,
            SpeciesGenderSeeder::class,
            MaturitySeeder::class,
            CountingMethodSeeder::class,
            CountriesSeeder::class,
            ConflictTypeSeeder::class,
            ConflictOutComeSeeder::class,
            ControlMeasureSeeder::class,

        ]);
    }
}
