<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Key>
 */
class KeyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Item ' . strtoupper(fake()->randomLetter()),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 0, 500),
        ];
    }
}
