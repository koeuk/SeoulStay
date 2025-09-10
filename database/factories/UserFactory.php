<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\UserType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $koreanNames = [
            ['first' => 'Min', 'last' => 'Kim'], ['first' => 'Ji', 'last' => 'Lee'], ['first' => 'Hyun', 'last' => 'Park'],
            ['first' => 'Soo', 'last' => 'Choi'], ['first' => 'Jun', 'last' => 'Jung'], ['first' => 'Young', 'last' => 'Kang'],
            ['first' => 'Hye', 'last' => 'Yoon'], ['first' => 'Dong', 'last' => 'Jang'], ['first' => 'Sung', 'last' => 'Lim'],
            ['first' => 'Mi', 'last' => 'Han'], ['first' => 'Jae', 'last' => 'Oh'], ['first' => 'Eun', 'last' => 'Shin'],
            ['first' => 'Kyung', 'last' => 'Kwon'], ['first' => 'Se', 'last' => 'Yu'], ['first' => 'Won', 'last' => 'Song']
        ];

        $name = $this->faker->randomElement($koreanNames);
        $firstName = $name['first'];
        $lastName = $name['last'];
        $username = strtolower($firstName . '.' . $lastName . rand(100, 999));

        return [
            'uuid' => Str::uuid(),
            'user_type_id' => UserType::inRandomOrder()->first()?->id ?? 1,
            'username' => $username,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'full_name' => $firstName . ' ' . $lastName,
            'name' => $firstName . ' ' . $lastName,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'birth_date' => $this->faker->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
            'family_count' => $this->faker->numberBetween(0, 8),
            'email_verified_at' => $this->faker->boolean(80) ? now() : null,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create user with specific user type.
     */
    public function withUserType(string $typeName): static
    {
        return $this->state(function (array $attributes) use ($typeName) {
            $userType = UserType::where('name', $typeName)->first();
            return [
                'user_type_id' => $userType?->id ?? 1,
            ];
        });
    }
}
