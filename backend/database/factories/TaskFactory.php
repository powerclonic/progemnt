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
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->boolean() ? fake()->paragraph() : null,
            'deadline' => fake()->boolean() ? fake()->dateTimeBetween('+1 week', '+10 years')->format('Y-m-d') : null,
            'status' => rand(1, 4)
        ];
    }
}
