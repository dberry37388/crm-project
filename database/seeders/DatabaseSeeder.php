<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Note;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'jdoe@example.org'
        ]);

        // create two teams for the admin user
        $teams = Team::factory(2)->create([
            'user_id' => $adminUser->id
        ]);

        foreach ($teams as $team) {
            // create some users
            $users = User::factory(rand(3, 10))->create([
                'current_team_id' => $team->id
            ]);

            foreach ($users as $user) {
                $user->teams()->attach($team->id);
            }

            $companies = Company::factory(10)->create([
                'team_id' => $team->id,
                'created_by_id' => $users->random()->id
            ]);

            // create some contacts
            $contacts = Contact::factory(200)->create([
                'team_id' => $team->id,
                'created_by_id' => $adminUser->id,
                'assigned_to_id' => $users->random()->id
            ]);

            foreach ($contacts->random(20, $contacts->count()) as $contact) {
                $company = $companies->random();
                $company->contacts()->attach($contact);
            }

             Note::factory()->count(rand(50, 100))->contact()->state(
                 ['noteable_id' => $contacts->random()->id]
             )->create();

            Note::factory()->count(rand(50, 100))->company()->state(
                ['noteable_id' => $companies->random()->id]
            )->create();
        }
    }
}
