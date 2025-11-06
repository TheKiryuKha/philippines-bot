<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

final readonly class CreateProductAction
{
    /**
     * @param array{
     * image_link: string,
     * title: string,
     * description: string,
     * options: array<array{type: string, volume: string, price: int}>
     * } $attr
     */
    public function handle(array $attr): void
    {
        DB::transaction(function () use ($attr): void {

            $product = Product::create([
                'title' => $attr['title'],
                'description' => $attr['description'],
            ]);

            foreach ($attr['options'] as $option) {
                $product->options()->create($option);
            }

            $product
                ->addMediaFromUrl($attr['image_link'])
                ->toMediaCollection('image');
        });
    }
}
