<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
final class CartFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'products_amount' => 0,
            'price' => 0,
        ];
    }

    public function price(int $price): self
    {
        return $this->state(fn (array $attributes): array => [
            'price' => $price,
        ]);
    }

    public function withItem(int $amount): self
    {
        return $this->has(
            CartItem::factory()->amount($amount),
            'items'
        )->afterCreating(function (Cart $cart): void {
            $cart->update([
                'products_amount' => $cart->items->sum('amount'),
                'price' => $cart->items->sum(fn ($item): int|float => $item->product->price * $item->amount),
            ]);
        });
    }
}
