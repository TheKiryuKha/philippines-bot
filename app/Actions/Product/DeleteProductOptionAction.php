<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Actions\Cart\EditCartAction;
use App\Models\ProductOption;
use Illuminate\Support\Facades\DB;

final readonly class DeleteProductOptionAction
{
    public function __construct(
        private EditCartAction $action
    ) {}

    public function handle(ProductOption $option): void
    {
        DB::transaction(function () use ($option): void {

            foreach ($option->cart_items as $item) {
                $cart = $item->cart;

                $this->action->handle($cart, [
                    'amount' => -$item->amount,
                    'price' => -$option->price,
                ]);

                $item->delete();
            }

            $option->delete();
        });
    }
}
