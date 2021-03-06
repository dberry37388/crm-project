<?php

namespace Database\Factories;

use App\Models\Industry;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'created_by_id' => User::factory(),
            'assigned_to_id' => User::factory(),
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'number_of_employees' => rand(1,100),
            'timezone' => $this->faker->timezone,
            'industry_id' => Industry::inRandomOrder()->first('id')->id
        ];
    }
}
