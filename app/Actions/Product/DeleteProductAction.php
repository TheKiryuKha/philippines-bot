<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Actions\Cart\EditCartAction;
use App\Models\Product;
use App\Services\ProductCacheService;
use Illuminate\Support\Facades\DB;

final readonly class DeleteProductAction
{
    public function __construct(
        private EditCartAction $action,
        private ProductCacheService $cache,
    ) {}

    public function handle(Product $product): void
    {
        DB::transaction(function () use ($product): void {

            foreach ($product->cart_items as $cart_item) {
                $cart = $cart_item->cart;

                $this->action->handle($cart, [
                    'amount' => -$cart_item->amount,
                    'price' => -$product->price * $cart_item->amount,
                ]);

                $cart_item->delete();
            }

            $product->delete();

            $this->cache->clear();
        });
    }
}
