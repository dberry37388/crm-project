<?php

namespace Database\Seeders;

use App\Models\Company;
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

        $users = User::factory(rand(3,6))->create();

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

            Company::factory(rand(2,20))->create([
                'team_id' => $team->id,
                'created_by_id' => $adminUser->id
            ]);
        }
    }
}
