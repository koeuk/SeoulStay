<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Amenities>
 */
class AmenitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amenities = [
            ['name' => 'Free WiFi', 'icon' => '028-connection.png'],
            ['name' => 'Parking', 'icon' => '001-home.png'],
            ['name' => 'Air Conditioning', 'icon' => '042-air-conditioner.png'],
            ['name' => 'Kitchen', 'icon' => '078-kitchen.png'],
        ];

        $amenity = $this->faker->unique()->randomElement($amenities);

        return [
            'uuid' => Str::uuid(),
            'name' => $amenity['name'],
            'icon_name' => $amenity['icon'],
        ];
    }
}