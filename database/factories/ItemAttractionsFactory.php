<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Items;
use App\Models\Attractions;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemAttractions>
 */
class ItemAttractionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $distance = $this->faker->randomFloat(2, 0.1, 50.0);
        $durationOnFoot = (int) ($distance * 15); // ~15 minutes per km walking
        $durationByCar = (int) ($distance * 3); // ~3 minutes per km by car
        
        return [
            'uuid' => Str::uuid(),
            'item_id' => Items::inRandomOrder()->first()?->id ?? 1,
            'attraction_id' => Attractions::inRandomOrder()->first()?->id ?? 1,
            'distance' => $distance,
            'duration_on_foot' => $durationOnFoot,
            'duration_by_car' => $durationByCar,
        ];
    }
}
