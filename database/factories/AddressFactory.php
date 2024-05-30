<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'street' => fake()->streetAddress(),
            'number' => fake()->buildingNumber(),
            'zip_code' => '75700-000', // fake()->postcode(),
            'city' => fake()->city(),
            'state' => 'state_x', //fake()->stateAbbr(),
            'country' => 'country_x' // fake()->countryCode(),
        ];
    }
}
