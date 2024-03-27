<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            ['name' => 'Education', 'description' => 'Projects focused on building educational facilities and programs, such as schools and libraries.'],
            ['name' => 'Water Supply', 'description' => 'Initiatives aimed at improving water access through wells, boreholes, and water treatment facilities.'],
            ['name' => 'Infrastructure', 'description' => 'Development of essential community infrastructure such as roads, bridges, and public buildings.'],
            ['name' => 'Healthcare', 'description' => 'Projects to enhance healthcare services and facilities in the community, including clinics and health awareness programs.'],
            ['name' => 'Agriculture', 'description' => 'Agricultural projects to support food security and sustainable farming practices, including irrigation and crop diversity.'],
            ['name' => 'Renewable Energy', 'description' => 'Projects focused on implementing renewable energy sources such as solar panels and wind turbines to provide sustainable energy solutions.'],
            ['name' => 'Community Development', 'description' => 'Initiatives aimed at overall community development, including community centers, sports facilities, and recreational areas.'],
            ['name' => 'Environmental Conservation', 'description' => 'Conservation projects aimed at protecting and preserving natural habitats, wildlife, and promoting sustainable practices.'],
            ['name' => 'Disaster Relief', 'description' => 'Projects focused on disaster preparedness, emergency response, and rehabilitation efforts in the aftermath of natural disasters.'],
            ['name' => 'Cultural Preservation', 'description' => 'Initiatives aimed at preserving and promoting local culture, traditions, and heritage through museums, cultural events, and education.'],
            // Add more categories as needed
        ];

        foreach ($categories as $category) {
            \App\Models\ProjectCategory::create($category);
        }
    }
}
