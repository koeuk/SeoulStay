<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemType>
 */
class ItemTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $itemTypes = [
            'Private room', 'Entire place', 'Shared room', 'Hotel room',
            'Studio apartment', 'One bedroom', 'Two bedroom', 'Three bedroom',
            'Penthouse', 'Loft', 'Villa', 'Townhouse',
            'Guesthouse', 'Hostel', 'Boutique hotel', 'Resort',
            'Serviced apartment', 'Executive suite', 'Family room', 'Luxury suite'
        ];

        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->unique()->randomElement($itemTypes),
        ];
    }
}
