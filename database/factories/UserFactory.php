<?php

namespace Database\Factories;

use App\Commons\Database\ConstantsPool as D;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            D::NAME => fake()->name(),
            D::EMAIL => fake()->unique()->safeEmail(),
            D::EMAIL_VERIFIED_AT => now(),
            D::PASSWORD => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            D::REMEMBER_TOKEN => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            D::EMAIL_VERIFIED_AT => null,
        ]);
    }
}
