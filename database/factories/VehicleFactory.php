<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'year' => fake()->year(),
            'make' => ucfirst(fake()->word()),
            'model' => ucfirst(fake()->word()),
            'vin' => fake()->randomNumber(9),
        ];
    }
}
