<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\DB;

final readonly class DeleteCartAction
{
    public function handle(Cart $cart): void
    {
        DB::transaction(function () use ($cart): void {
            $cart->items()->delete();

            $cart->update([
                'products_amount' => 0,
                'price' => 0,
            ]);
        });
    }
}
