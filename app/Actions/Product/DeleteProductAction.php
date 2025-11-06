<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Support\Facades\DB;

final readonly class DeleteProductAction
{
    public function __construct(
        private DeleteProductOptionAction $action
    ) {}

    public function handle(Product $product): void
    {
        DB::transaction(function () use ($product): void {

            $product->options()->each(
                fn (ProductOption $option) => $this->action->handle($option)
            );

            $product->delete();
        });
    }
}
