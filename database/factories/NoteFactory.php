<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
//            'noteable_id' => Company::factory(),
//            'noteable_type' => function (array $attributes) {
//                return Company::find($attributes['noteable_id'])->type;
//            },
            'created_by_id' => User::factory(),
            'note' => $this->faker->paragraph
        ];
    }

    /**
     * @return NoteFactory \Database\Factories\NoteFactory
     */
    public function contact(): NoteFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'noteable_id' => Contact::factory(),
                'noteable_type' => 'App\Models\Contact',
            ];
        });
    }

    /**
     * @return NoteFactory \Database\Factories\NoteFactory
     */
    public function company(): NoteFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'noteable_id' => Company::factory(),
                'noteable_type' => 'App\Models\Company',
            ];
        });
    }
}
