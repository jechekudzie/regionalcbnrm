<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'name' => 'Nigel Jeche',
                'email' => 'jechekudzie@gmail.com',
                'password' => 'password@1',
                'organisation_id' => 4, // Assigning to organisation with ID 2
            ],
            [
                'name' => 'Dr Shylock Muyengwa',
                'email' => 'shylock.muyengwa@resourceafrica.net',
                'password' => 'password@2',
                'organisation_id' => 2, // Assigning to organisation with ID 4
            ],
        ];

        foreach ($users as $userData) {
            // Find the organisation for the current user, skip if not found
            $organisation = Organisation::find($userData['organisation_id']);
            if (!$organisation) {
                continue; // Skip this user if the organisation doesn't exist
            }

            // Create the user
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            // Check if the 'super-admin' role already exists for the organisation
            $role = Role::firstOrCreate([
                'name' => 'super-admin',
                'guard_name' => 'web',
                'organisation_id' => $organisation->id,
            ]);

            // Assign the role to the user
            $user->roles()->attach($role->id, [
                'model_type' => get_class($user),
                'organisation_id' => $organisation->id
            ]);

            // Attach the user to the organisation with the specified role
            $organisation->users()->attach($user->id, ['role_id' => $role->id]);
        }
    }
}
