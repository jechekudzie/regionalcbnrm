<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $statuses = [
            ['name' => 'Planning', 'description' => 'The project is in the planning phase.'],
            ['name' => 'Active', 'description' => 'The project is currently underway.'],
            ['name' => 'Completed', 'description' => 'The project has been successfully completed.'],
            ['name' => 'On Hold', 'description' => 'The project is temporarily paused.'],
            // Add more statuses as needed
        ];

        foreach ($statuses as $status) {
            \App\Models\ProjectStatus::create($status);
        }
    }
}
