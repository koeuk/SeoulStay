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
            ['name' => 'Washer & Dryer', 'icon' => '089-washing-machine.png'],
            ['name' => 'TV', 'icon' => '025-tv.png'],
            ['name' => 'Gym', 'icon' => '156-gym.png'],
            ['name' => 'Pool', 'icon' => '234-swimming-pool.png'],
            ['name' => 'Hot Tub', 'icon' => '187-hot-tub.png'],
            ['name' => 'Breakfast', 'icon' => '164-spoon-knife.png'],
            ['name' => 'Room Service', 'icon' => '274-checkmark2.png'],
            ['name' => 'Concierge', 'icon' => '198-bell-boy.png'],
            ['name' => 'Business Center', 'icon' => '085-printer.png'],
            ['name' => 'Pet Friendly', 'icon' => '312-dog.png'],
            ['name' => 'Balcony', 'icon' => '456-balcony.png'],
            ['name' => 'Garden View', 'icon' => '567-garden.png'],
            ['name' => 'City View', 'icon' => '678-city.png'],
            ['name' => 'River View', 'icon' => '789-river.png'],
            ['name' => 'Mountain View', 'icon' => '890-mountain.png'],
            ['name' => 'Security System', 'icon' => '143-key2.png']
        ];

        $amenity = $this->faker->unique()->randomElement($amenities);

        return [
            'uuid' => Str::uuid(),
            'name' => $amenity['name'],
            'icon_name' => $amenity['icon'],
        ];
    }
}
