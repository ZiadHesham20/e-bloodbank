<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HospitalUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hospital_id' => $this->faker->numberBetween(1, 10),
            'user_id' => $this->faker->numberBetween(1, 100),
            'type' => $this->faker->numberBetween(0, 1),
        ];
    }
}
