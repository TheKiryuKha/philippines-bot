<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductOption;
use Illuminate\Support\Facades\DB;

final readonly class CreateCartItemAction
{
    public function __construct(
        private EditCartAction $action
    ) {}

    public function handle(Cart $cart, ProductOption $option): CartItem
    {
        return DB::transaction(function () use ($cart, $option): CartItem {

            $item = $cart->items()->firstOrCreate(
                ['product_option_id' => $option->id],
                ['amount' => 0]
            );

            $item->increment('amount');

            $this->action->handle($cart, [
                'amount' => 1,
                'price' => $option->price,
            ]);

            return $item;
        });
    }
}
