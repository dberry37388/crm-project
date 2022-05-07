<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (! $user = User::inRandomOrder()->first()) {
            $user = User::factory()->create();
        }

        if (! $team = Team::inRandomOrder()->first()) {
            $team = Team::factory()->create();
        }

        return [
            'team_id' => $team->id,
            'created_by_id' => $user->id,
            'assigned_to_id' => $user->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'job_title' => $this->faker->jobTitle,
            'phone_number' => $this->faker->e164PhoneNumber,
            'mobile_number' => $this->faker->e164PhoneNumber,
        ];
    }
}
