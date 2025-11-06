<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'chat_id' => fake()->unique()->randomNumber(),
            'remember_token' => Str::random(10),
        ];
    }

    public function chat_id(int $id): self
    {
        return $this->state(fn (array $attributes): array => [
            'chat_id' => $id,
        ]);
    }

    public function withCart(int $items_amount = 0): self
    {
        return $this->state(fn (array $attributes): array => [])
            ->afterCreating(function (User $user) use ($items_amount): void {
                Cart::factory()
                    ->withItem($items_amount)
                    ->for($user)
                    ->create();
            });
    }

    public function withInvoice(): self
    {
        return $this->state(fn (array $attributes): array => [])
            ->afterCreating(function (User $user): void {
                Invoice::factory()->for($user)->create();
            });
    }

    public function withExpiredInvoice(): self
    {
        return $this->state(fn (array $attributes): array => [])
            ->afterCreating(function (User $user): void {
                Invoice::factory()->for($user)->expired()->create();
            });
    }
}
