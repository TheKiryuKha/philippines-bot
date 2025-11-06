<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
final class InvoiceFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => InvoiceStatus::Created,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'middle_name' => fake()->firstName(),
            'delivery_address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'price' => 0,
            'user_id' => User::factory(),
            'expires_at' => now()->addMinutes(30),
        ];
    }

    public function paid(): self
    {
        return $this->state(fn (array $attrbibutes): array => [
            'status' => InvoiceStatus::Paid,
        ]);
    }

    public function expired(): self
    {
        return $this->state(fn (array $attrbibutes): array => [
            'expires_at' => now()->subMinutes(40),
        ]);
    }

    public function price(int $price): self
    {
        return $this->state(fn (array $attrbibutes): array => [
            'price' => $price,
        ]);
    }

    public function withItems(int $amount = 1): self
    {
        return $this->state(
            fn (array $attrbibutes): array => []
        )->afterCreating(function (Invoice $invoice) use ($amount): void {

            $items = InvoiceItem::factory()
                ->for($invoice)
                ->amount($amount)
                ->create();
        });
    }
}
