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
            'Owner', 'Manager', 'Traveler', 'Employee', 'Guest',
            'Premium Owner', 'Property Manager', 'Business Traveler',
            'Vacation Renter', 'Corporate User', 'VIP Guest',
            'Real Estate Agent', 'Tour Guide', 'Hotel Manager',
            'Apartment Owner', 'Condo Manager', 'Holiday Renter',
            'Executive User', 'Standard User', 'Administrator'
        ];

        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->unique()->randomElement($userTypes),
        ];
    }
}
