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
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'completed', 'overdue']),
            'due_date' => $this->faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
        ];
    }
}
