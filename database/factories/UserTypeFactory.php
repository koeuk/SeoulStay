<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserType>
 */
class UserTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userTypes = [
            'Owner', 'Manager', 'Traveler', 'Administrator'
        ];

        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->unique()->randomElement($userTypes),
        ];
    }
}