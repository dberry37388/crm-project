<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\Note;
use App\Models\Scopes\TeamScope;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

            Company::factory(rand(5,18))
                ->state(new Sequence(
                    fn ($sequence) => [
                        'created_by_id' => $team->users()->inRandomOrder()->first()->id,
                        'assigned_to_id' => $team->users()->inRandomOrder()->first()->id,
                    ]))
                ->create([
                    'team_id' => $team->id,
                ])->each(function ($company) use($team) {
                    $this->addRelations($company, $team);
                });

            Deal::factory(rand(5,18))
                ->state(new Sequence(
                    fn ($sequence) => [
                        'created_by_id' => $team->users()->inRandomOrder()->first()->id,
                        'owned_by_id' => $team->users()->inRandomOrder()->first()->id,
                    ]))
                ->create([
                    'team_id' => $team->id,
                ])->each(function ($deal) use($team) {
                   $this->addRelations($deal, $team);
                });

            Contact::factory(3)
                ->state(new Sequence(
                    fn($sequence) => [
                        'created_by_id' => $team->users()->inRandomOrder()->first()->id,
                        'assigned_to_id' => $team->users()->inRandomOrder()->first()->id,
                    ]))
                ->create()
                ->each(function ($contact) use ($team) {
                    $contact->deals()->attach(Deal::inRandomOrder()->first());
                    $contact->companies()->attach(Company::inRandomOrder()->first());
                    $this->addRelations($contact, $team);
                });
        });
    }

    /**
     * @param $relation
     * @param $team
     * @return void
     */
    function addRelations($relation, $team): void
    {
        // add notes
        Note::factory()->count(3)->for(
            $relation, 'noteable'
        )->state(new Sequence(
            fn($sequence) => [
                'created_by_id' => $team->users()->inRandomOrder()->first()->id,
            ]))
            ->create();

        // add tasks
        Task::factory()->count(3)->for(
            $relation, 'taskable'
        )->state(new Sequence(
            fn($sequence) => [
                'created_by_id' => $team->users()->inRandomOrder()->first()->id,
                'assigned_to_id' => $team->users()->inRandomOrder()->first()->id,
            ]))
            ->create();
    }
}
