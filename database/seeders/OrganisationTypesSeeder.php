<?php

namespace Database\Seeders;

use App\Models\OrganisationType;
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
            ["name" => "Media & Broadcasting", "description" => "Providers of media coverage and broadcasting services for events."],
            ["name" => "Sound & Audio Equipment", "description" => "Suppliers of sound and audio equipment for events."],
            ["name" => "Event Venues", "description" => "Locations available for hosting various types of events."],
            ["name" => "Decoration & Design Services", "description" => "Providers of decor and design services for events."],
            ["name" => "Catering Services", "description" => "Providers of food and beverage services for events."],
            ["name" => "Photography & Videography", "description" => "Professional photography and videography services for events."],
            ["name" => "Event Planning & Coordination", "description" => "Services for planning and coordinating all aspects of events."],
            ["name" => "Lighting & Special Effects", "description" => "Providers of lighting and special effects for events."],
            ["name" => "Entertainment & Performers", "description" => "Entertainers and performers suitable for various event types."],
            ["name" => "Security & Crowd Management", "description" => "Services for event security and crowd management."],
            ["name" => "Transportation Services", "description" => "Providers of transportation for events and attendees."],
            ["name" => "Event Technology Solutions", "description" => "Providers of technology solutions like audio-visual equipment."],
            ["name" => "Hospitality & Accommodation", "description" => "Hotels and other accommodations for event attendees."],
            ["name" => "Marketing & Promotion", "description" => "Services for marketing and promoting events."]
        ];

        foreach ($organisationTypes as $type) {
            OrganisationType::create($type);
        }

    }
}
