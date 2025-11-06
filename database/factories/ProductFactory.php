<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
final class ProductFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'price' => fake()->numberBetween(1000, 1000000),
        ];
    }

    public function price(int $price): self
    {
        return $this->state(fn (array $attrbiutes): array => [
            'price' => $price,
        ]);
    }

    public function withImage(): self
    {
        return $this->state(fn (array $attributes): array => [])
            ->afterCreating(function (Product $product): void {
                $product->addMedia(
                    UploadedFile::fake()->image('test.png')
                )->toMediaCollection('image');
            });
    }

    public function inCart(): self
    {
        return $this->state(fn (array $attributes): array => [])
            ->afterCreating(function (Product $product): void {

                $cart = Cart::factory()->create([
                    'products_amount' => 1,
                    'price' => $product->price,
                ]);

                CartItem::factory()
                    ->for($cart)
                    ->for($product)
                    ->create(['amount' => 1]);
            });
    }
}
