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
            ['name' => 'Hongdae Nightlife', 'area' => 'Mapo-gu', 'address' => 'Hongik-ro, Mapo-gu'],
            ['name' => 'Gangnam District', 'area' => 'Gangnam-gu', 'address' => 'Gangnam-daero, Gangnam-gu'],
            ['name' => 'Dongdaemun Design Plaza', 'area' => 'Dongdaemun-gu', 'address' => '281 Eulji-ro, Dongdaemun-gu'],
            ['name' => 'Itaewon Global Village', 'area' => 'Yongsan-gu', 'address' => 'Itaewon-ro, Yongsan-gu'],
            ['name' => 'Lotte World Tower', 'area' => 'Songpa-gu', 'address' => '300 Olympic-ro, Songpa-gu'],
            ['name' => 'Banpo Rainbow Bridge', 'area' => 'Seocho-gu', 'address' => 'Banpo-daero, Seocho-gu'],
            ['name' => 'Insadong Cultural Street', 'area' => 'Jongno-gu', 'address' => 'Insadong-gil, Jongno-gu'],
            ['name' => 'Han River Park', 'area' => 'Yeongdeungpo-gu', 'address' => 'Yeouido-dong, Yeongdeungpo-gu'],
            ['name' => 'Changdeokgung Palace', 'area' => 'Jongno-gu', 'address' => '99 Yulgok-ro, Jongno-gu'],
            ['name' => 'Coex Aquarium', 'area' => 'Gangnam-gu', 'address' => '513 Yeongdong-daero, Gangnam-gu'],
            ['name' => 'Ewha Womans University', 'area' => 'Seodaemun-gu', 'address' => '52 Ewhayeodae-gil, Seodaemun-gu'],
            ['name' => 'Cheonggyecheon Stream', 'area' => 'Jung-gu', 'address' => 'Cheonggyecheon-ro, Jung-gu'],
            ['name' => 'Yeouido Park', 'area' => 'Yeongdeungpo-gu', 'address' => '68 Yeouigongwon-ro, Yeongdeungpo-gu'],
            ['name' => 'Olympic Park', 'area' => 'Songpa-gu', 'address' => '424 Olympic-ro, Songpa-gu'],
            ['name' => 'War Memorial of Korea', 'area' => 'Yongsan-gu', 'address' => '29 Itaewon-ro, Yongsan-gu'],
            ['name' => 'Namsan Park', 'area' => 'Jung-gu', 'address' => '231 Sogong-ro, Jung-gu']
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
