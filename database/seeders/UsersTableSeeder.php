<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //create a user with name Nigel Jeche and email jechekudzie@gmail.com password use Incorrect and Hash as laravel does
        $user = \App\Models\User::create([
            'name' => 'Nigel Jeche',
            'email' => 'jechekudzie@gmail.com',
            'password' => Hash::make('Incorrect'),
        ]);

    }
}
