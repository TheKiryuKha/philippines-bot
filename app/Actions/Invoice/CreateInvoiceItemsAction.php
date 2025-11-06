<?php

declare(strict_types=1);

namespace App\Actions\Invoice;

use App\Models\Cart;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

final readonly class CreateInvoiceItemsAction
{
    public function handle(Invoice $invoice, Cart $cart): void
    {
        DB::transaction(function () use ($invoice, $cart): void {

            foreach ($cart->items as $item) {
                $invoice->items()->create([
                    'product_id' => $item->product_id,
                    'amount' => $item->amount,
                ]);
            }
        });
    }
}
