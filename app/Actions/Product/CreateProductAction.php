<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Category;
use App\Services\CategoryCache;
use Illuminate\Support\Facades\DB;

final readonly class CreateProductAction
{
    public function __construct(
        private CategoryCache $cache
    ) {}

    /**
     * @param array{
     * image_link: string,
     * title: string,
     * description: string,
     * category_title: string,
     * options: array<array{type: string, volume: string, price: int}>
     * } $attr
     */
    public function handle(array $attr): void
    {
        DB::transaction(function () use ($attr): void {

            $category = Category::firstOrCreate(
                ['title' => $attr['category_title']]
            );

            $product = $category->products()->create([
                'title' => $attr['title'],
                'description' => $attr['description'],
            ]);

            foreach ($attr['options'] as $option) {
                $product->options()->create($option);
            }

            $product
                ->addMediaFromUrl($attr['image_link'])
                ->toMediaCollection('image');

            $this->cache->forget();

        });
    }
}
