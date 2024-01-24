<?php

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     function run(): void
    {
        //
        $species = [
            ['name' => 'Elephant', 'scientific' => 'Elephas maximus, Loxodonta africana', 'male_name' => 'Bull', 'female_name' => 'Cow', 'avatar' => '/images/elephant.jpg'],
            ['name' => 'Lion', 'scientific' => 'Panthera leo', 'male_name' => 'Lion', 'female_name' => 'Lioness', 'avatar' => '/images/lion.jpg'],
            ['name' => 'Leopard', 'scientific' => 'Panthera pardus', 'male_name' => 'Leopard', 'female_name' => 'Leopardess', 'avatar' => '/images/leopard.jpg'],
            ['name' => 'Buffalo', 'scientific' => 'Syncerus caffer, Bubalus bubalis', 'male_name' => 'Bull', 'female_name' => 'Cow', 'avatar' => '/images/buffalo.jpg'],
            ['name' => 'Crocodile', 'scientific' => 'Crocodylus niloticus, Crocodylus porosus', 'male_name' => 'Bull', 'female_name' => 'Cow', 'avatar' => '/images/crocodile.jpg'],
            ['name' => 'Hippo', 'scientific' => 'Hippopotamus amphibius', 'male_name' => 'Bull', 'female_name' => 'Cow', 'avatar' => '/images/hippo.jpg'],
            ['name' => 'Hyena - Spotted', 'scientific' => 'Crocuta crocuta', 'male_name' => 'Male Hyena', 'female_name' => 'Female Hyena', 'avatar' => '/images/hyena - spotted.jpg'],
            ['name' => 'Hyena - Brown', 'scientific' => 'Hyaena brunnea', 'male_name' => 'Male Hyena', 'female_name' => 'Female Hyena', 'avatar' => '/images/hyena - brown.jpg'],
            ['name' => 'Wild Dogs', 'scientific' => 'Lycaon pictus', 'male_name' => 'Male', 'female_name' => 'Female', 'avatar' => '/images/wild dogs.jpg'],
            ['name' => 'Jackal', 'scientific' => 'Canis aureus, Canis mesomelas', 'male_name' => 'Male', 'female_name' => 'Female', 'avatar' => '/images/jackal.jpg'],
            ['name' => 'Snakes', 'scientific' => 'Varies by species', 'male_name' => 'Male', 'female_name' => 'Female', 'avatar' => '/images/snakes.jpeg'],
            ['name' => 'Python', 'scientific' => 'Python regius, Python bivittatus', 'male_name' => 'Male', 'female_name' => 'Female', 'avatar' => '/images/python.jpg'],
            ['name' => 'Wild Pigs', 'scientific' => 'Sus scrofa', 'male_name' => 'Boar', 'female_name' => 'Sow', 'avatar' => '/images/wild pigs.jpg'],
            ['name' => 'Antelopes', 'scientific' => 'Varies by species', 'male_name' => 'Buck', 'female_name' => 'Doe', 'avatar' => '/images/antelopes.jpg'],
            ['name' => 'Quelea Birds', 'scientific' => 'Quelea quelea', 'male_name' => 'Male Quelea', 'female_name' => 'Female Quelea', 'avatar' => '/images/quelea birds.jpeg'],
        ];


        foreach ($species as $specie) {
            Species::create($specie);
        }
    }
}
