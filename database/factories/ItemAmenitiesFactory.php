<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Items;
use App\Models\Amenities;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemAmenities>
 */
class ItemAmenitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'item_id' => Items::inRandomOrder()->first()?->id ?? 1,
            'amenity_id' => Amenities::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
