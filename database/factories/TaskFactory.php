<?php

namespace Database\Factories;

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
        return [
            'user_id' => 0,
            'name' => $this->faker->unique()->words(2, true),
            'content' => $this->faker->words(5, true),
            'deadline' => $this->faker->dateTimeBetween('0 week', '+1 month'),
            'status' => 0,
            'created_at' => now()
        ];
    }

    /**
     * Indicate that the model's task status should be closed.
     *
     * @return static
     */
    public function closed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 1,
            ];
        });
    }
}
