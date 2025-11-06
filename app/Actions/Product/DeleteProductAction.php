<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use App\Models\ProductOption;
use App\Services\CategoryCache;
use Illuminate\Support\Facades\DB;

final readonly class DeleteProductAction
{
    public function __construct(
        private CategoryCache $cache,
        private DeleteProductOptionAction $action
    ) {}

    public function handle(Product $product): void
    {
        DB::transaction(function () use ($product): void {

            $product->options()->each(
                fn (ProductOption $option) => $this->action->handle($option)
            );

            $product->delete();

            $category = $product->category;

            if ($category->products()->doesntExist()) {
                $category->delete();
            }

            $this->cache->forget();
        });
    }
}
