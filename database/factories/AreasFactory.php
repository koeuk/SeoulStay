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
            'Gangdong-gu', 'Gangnam-gu', 'Gangseo-gu', 'Geumcheon-gu',
            'Guro-gu', 'Jongno-gu', 'Jung-gu', 'Jungnang-gu',
            'Mapo-gu', 'Nowon-gu', 'Seocho-gu', 'Seodaemun-gu',
            'Seongbuk-gu', 'Seongdong-gu', 'Songpa-gu', 'Yangcheon-gu',
            'Yeongdeungpo-gu', 'Yongsan-gu'
        ];

        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->unique()->randomElement($seoulAreas),
        ];
    }
}
