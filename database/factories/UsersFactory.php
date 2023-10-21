<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<, mixed>
     */
    public function definition(): array
    {
        return [
           'name'=>fake()->name(),
           'email'=>fake()->email(),
           'password'=>fake()->password(),
           'age'=>fake()->numberBetween(18,65),
           'phone'=>fake()->phoneNumber(),
           'gender'=>fake()->boolean(),
           'blood_type'=>fake()->bloodType(),
           'location'=>fake()->city(),
           'request_id'=>fake()->randomNumber(),
           'date_and_time'=>fake()->dateTime(),
        ];
    }
}
