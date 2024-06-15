<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Province;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ModuleSeeder::class,
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
            OffenceTypeSeeder::class,
            PoacherTypeSeeder::class,
            PoachingMethodSeeder::class,
            PoachingReasonSeeder::class,
            HuntingOutComeSeeder::class,
            IdentificationTypeSeeder::class,
            GenderSeeder::class,
            ShotsTableSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            CategorySeeder::class,
            PayableItemSeeder::class,
            ProjectStatusesTableSeeder::class,
            ProjectCategoriesTableSeeder::class,
            UsersTableSeeder::class,
            QuotaAllocationSeeder::class,
            /*OrganisationAdminSeeder::class,*/
        ]);
    }
}
