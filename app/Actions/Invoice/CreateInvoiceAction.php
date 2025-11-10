<?php

declare(strict_types=1);

namespace App\Actions\Invoice;

use App\Actions\Cart\DeleteCartAction;
use App\Enums\InvoiceStatus;
use App\Models\Cart;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

final readonly class CreateInvoiceAction
{
    public function __construct(
        private CreateInvoiceItemsAction $create_items,
        private DeleteCartAction $delete_cart,
    ) {}

    /**
     * @param array{
     * cart_id: int,
     * first_name: string,
     * last_name: string,
     * middle_name: string,
     * delivery_address: string,
     * phone: string
     * } $attr
     */
    public function handle(array $attr): Invoice
    {
        return DB::transaction(function () use ($attr): Invoice {

            $cart = Cart::findOrFail($attr['cart_id']);
            unset($attr['cart_id']);

            $invoice = Invoice::create([
                ...$attr,
                'price' => $cart->price,
                'status' => InvoiceStatus::Created,
                'expires_at' => now()->addMinutes(30),
                'user_id' => $cart->user_id,
            ]);

            $this->create_items->handle($invoice, $cart);

            $this->delete_cart->handle($cart);

            return $invoice;
        });
    }
}
