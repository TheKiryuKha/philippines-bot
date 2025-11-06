<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;

final readonly class EditCartAction
{
    /**
     * @param  array{amount: int, price: int}  $attr
     */
    public function handle(Cart $cart, array $attr): Cart
    {
        $cart->update([
            'products_amount' => $cart->products_amount + $attr['amount'],
            'price' => $cart->price + $attr['price'],
        ]);

        return $cart;
    }
}
