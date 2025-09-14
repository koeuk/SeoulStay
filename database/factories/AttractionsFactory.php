<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Areas;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attractions>
 */
class AttractionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $attractions = [
            ['name' => 'Gyeongbokgung Palace', 'area' => 'Jongno-gu', 'address' => '161 Sajik-ro, Jongno-gu'],
            ['name' => 'N Seoul Tower', 'area' => 'Yongsan-gu', 'address' => '105 Namsangongwon-gil, Yongsan-gu'],
            ['name' => 'Myeongdong Shopping District', 'area' => 'Jung-gu', 'address' => 'Myeongdong 2-ga, Jung-gu'],
            ['name' => 'Bukchon Hanok Village', 'area' => 'Jongno-gu', 'address' => '37 Gyedong-gil, Jongno-gu'],
        ];

        $attraction = $this->faker->unique()->randomElement($attractions);
        $area = Areas::where('name', $attraction['area'])->first();

        return [
            'uuid' => Str::uuid(),
            'area_id' => $area?->id ?? Areas::inRandomOrder()->first()?->id ?? 1,
            'name' => $attraction['name'],
            'address' => $attraction['address'],
        ];
    }
}