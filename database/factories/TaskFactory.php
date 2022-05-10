<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dueDate = Carbon::now()->addDays(rand(5,30));

        return [
            'taskable_id' => Company::factory(),
            'taskable_type' => function (array $attributes) {
                return Company::find($attributes['taskable'])->type;
            },
            'created_by_id' => User::factory(),
            'assigned_to_id' => User::factory(),
            'task' => $this->faker->sentence,
            'notes' => $this->faker->paragraph,
            'priority' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'due_date' => $dueDate->toDateTimeString(),
        ];
    }

    /**
     * @return TaskFactory \Database\Factories\NoteFactory
     */
    public function contact(): TaskFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'taskable_id' => Contact::factory(),
                'taskable_type' => 'App\Models\Contact',
            ];
        });
    }

    /**
     * @return TaskFactory \Database\Factories\NoteFactory
     */
    public function company(): TaskFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'taskable_id' => Company::factory(),
                'taskable_type' => 'App\Models\Company',
            ];
        });
    }
}
