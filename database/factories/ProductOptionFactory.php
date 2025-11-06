<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductOption>
 */
final class ProductOptionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'volume' => '50 ml',
            'price' => fake()->numberBetween(1000, 10000),
            'type' => fake()->randomElement([
                'керамика',
                'стекло',
                'кр. пакет',
            ]),
            'product_id' => Product::factory(),
        ];
    }

    public function price(int $price): self
    {
        return $this->state(fn (array $attributes): array => [
            'price' => $price,
        ]);
    }
}
