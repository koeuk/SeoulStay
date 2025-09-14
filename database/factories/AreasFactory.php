<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Areas>
 */
class AreasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seoulAreas = [
            'Dobong-gu', 'Dongdaemun-gu', 'Eunpyeong-gu', 'Gangbuk-gu',
        ];

        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->unique()->randomElement($seoulAreas),
        ];
    }
}