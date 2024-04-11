<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cost>
 */
class CostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => fake()->numberBetween(1, 10),
            "cost_category_id" => fake()->numberBetween(1, 5),
            "sum" => fake()->randomNumber(5, false),
            "comment" => fake()->paragraph(),
            "created_at" => now(),
            "updated_at" => now(),
        ];
    }
}
