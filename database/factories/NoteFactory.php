<?php

namespace Database\Factories;

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
            'user_id' => 1,
            'name' => $this->faker->name(),
            'content' => $this->faker->words(3, true),
            'deadline' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'status' => $this->faker->numberBetween(0, 3),
        ];
    }
}
