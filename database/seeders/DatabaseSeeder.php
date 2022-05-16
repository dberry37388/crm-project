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

        Team::factory(2)->create([
            'user_id' => $adminUser->id,
        ])->each(function ($team) use($adminUser) {
            // attach the admin user
            $team->users()->attach($adminUser, ['role' => 'admin']);

            // create some users
            User::factory(rand(4,5))->create([
                'current_team_id' => rand(1,2)
            ])->each(function ($user) use ($team) {
                $user->teams()->attach($team, ['role' => 'editor']);
            });
        });
    }
}
