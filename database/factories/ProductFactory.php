<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
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
            'category_id' => Category::factory(),
        ];
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

    public function withOptions(int $amount): self
    {
        return $this->state(fn (array $attributes): array => [])
            ->afterCreating(function (Product $product) use ($amount): void {
                ProductOption::factory($amount)
                    ->for($product)
                    ->create();
            });
    }

    public function inCart(): self
    {
        return $this->state(fn (array $attributes): array => [])
            ->afterCreating(function (Product $product): void {
                $option = $product->options()->first();

                $cart = Cart::factory()->create([
                    'products_amount' => 1,
                    'price' => $option->price,
                ]);

                CartItem::factory()
                    ->for($cart)
                    ->for($option, 'product_option')
                    ->create(['amount' => 1]);
            });
    }
}
