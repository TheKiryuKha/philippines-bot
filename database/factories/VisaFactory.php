<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visa>
 */
final class VisaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'expiration_date' => fake()->date('d.m.Y'),
        ];
    }

    public function expiration_date(string $date): self
    {
        return $this->state(fn (array $attributes): array => [
            'expiration_date' => $date,
        ]);
    }
}
