<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmergencyRequest>
 */
class EmergencyRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 100),
            'blood_id' => $this->faker->numberBetween(1, 10),
            'phone' => $this->faker->phoneNumber(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'dateTime' => $this->faker->dateTime($min = 'now'),
            'city' => $this->faker->city(),
            'location' => $this->faker->name(),
        ];
    }
}
