<?php

declare(strict_types=1);

use App\Models\InvoiceItem;

test('to array', function () {
    $invoice_item = InvoiceItem::factory()->create()->fresh();

    expect(array_keys($invoice_item->toArray()))
        ->toBe([
            'id',
            'invoice_id',
            'product_id',
            'amount',
            'created_at',
            'updated_at',
        ]);
});
