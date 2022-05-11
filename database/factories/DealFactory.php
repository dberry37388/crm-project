<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(1000, 20000),
            'owner_id' => User::factory(),
            'created_by_id' => User::factory(),
            'company_id' => Company::factory(),
            'type' => $this->faker->randomElement(config('defaults.deals.types')),
            'stage' => $this->faker->randomElement(config('defaults.deals.stages')),
            'priority' => $this->faker->randomElement(config('defaults.priorities')),
        ];
    }
}
