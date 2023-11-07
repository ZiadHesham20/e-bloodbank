<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<, mixed>
     */
    public function definition(): array
    {
        return [
            'blood_id' => $this->faker->numberBetween(1, 8),
            'hospital_id' => $this->faker->numberBetween(1, 10),
            'name' =>fake()->name(),
            'email' =>fake()->email(),
            'password' =>fake()->password(),
            'age' =>fake()->numberBetween(18,65),
            'phone' =>fake()->phoneNumber(),
            'gender' =>fake()->boolean(),
            'location' =>fake()->city(),
            'donation_date' =>fake()->dateTime(),
        ];
    }
}
