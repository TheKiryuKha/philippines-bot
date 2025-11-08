<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
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

    public function expiries_in_two_weeks(): self
    {
        return $this->state(fn (array $attributes): array => [
            'expiration_date' => Carbon::today()->addWeeks(2)->format('d.m.Y'),
        ]);
    }

    public function expiries_in_week(): self
    {
        return $this->state(fn (array $attributes): array => [
            'expiration_date' => Carbon::today()->addWeek()->format('d.m.Y'),
        ]);
    }

    public function expiries_in_one_day(): self
    {
        return $this->state(fn (array $attributes): array => [
            'expiration_date' => Carbon::today()->addDay(),
        ]);
    }
}
