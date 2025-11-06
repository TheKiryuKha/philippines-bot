<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

final readonly class EditCartItemAction
{
    public function __construct(
        private EditCartAction $action
    ) {}

    public function handle(CartItem $cart_item): CartItem
    {
        return DB::transaction(function () use ($cart_item): CartItem {
            $cart_item->decrement('amount');

            if ($cart_item->amount === 0) {
                $cart_item->delete();
            }

            $this->action->handle($cart_item->cart, [
                'amount' => -1,
                'price' => -$cart_item->product_option->price,
            ]);

            return $cart_item;
        });
    }
}
