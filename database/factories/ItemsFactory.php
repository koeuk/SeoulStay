<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Areas;
use App\Models\ItemType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Items>
 */
class ItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $koreanPropertyNames = [
            'Seoul Garden House', 'Hanok Traditional Stay', 'Modern Seoul Apartment',
            'Gangnam Luxury Condo',
        ];

        $koreanAddresses = [
            '123 Gangnam-daero, Gangnam-gu', '456 Hongik-ro, Mapo-gu', '789 Myeongdong-gil, Jung-gu',
            '321 Itaewon-ro, Yongsan-gu', 
        ];

        return [
            'uuid' => Str::uuid(),
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'area_id' => Areas::inRandomOrder()->first()?->id ?? 1,
            'item_type_id' => ItemType::inRandomOrder()->first()?->id ?? 1,
            'title' => $this->faker->randomElement($koreanPropertyNames) . ' ' . $this->faker->numberBetween(1, 999),
            'capacity' => $this->faker->numberBetween(1, 10),
            'number_of_beds' => $this->faker->numberBetween(1, 6),
            'number_of_bedrooms' => $this->faker->numberBetween(1, 5),
            'number_of_bathrooms' => $this->faker->numberBetween(1, 3),
            'exact_address' => $this->faker->randomElement($koreanAddresses),
            'approximate_address' => $this->faker->randomElement($koreanAddresses),
            'description' => $this->faker->realText(200),
            'attributes' => json_encode([
                'wifi' => true,
                'parking' => $this->faker->boolean(70),
                'kitchen' => $this->faker->boolean(60),
                'air_conditioning' => $this->faker->boolean(80),
            ]),
            'minimum_nights' => $this->faker->numberBetween(1, 7),
            'maximum_nights' => $this->faker->numberBetween(30, 365),
        ];
    }
}