<?php

declare(strict_types=1);

use App\Enums\InvoiceStatus;
use App\Models\Invoice;

test('to array', function () {
    $invoice = Invoice::factory()->create()->fresh();

    expect(array_keys($invoice->toArray()))
        ->toBe([
            'id',
            'status',
            'first_name',
            'last_name',
            'middle_name',
            'delivery_address',
            'phone',
            'price',
            'user_id',
            'expires_at',
            'created_at',
            'updated_at',
        ]);
});

test('status', function () {
    $invoice = Invoice::factory()->create();

    expect($invoice->status)->toBeInstanceOf(InvoiceStatus::class);
});

// test('delivery_price', function () {
//     $invoice = Invoice::factory()->create();

//     $this->assertDatabaseHas('invoices', [
//         'id' => $invoice->id,
//         'delivery_price' => $invoice->delivery_price * 100,
//     ]);
// });

// test('total_price', function () {
//     $invoice = Invoice::factory()->create();

//     $this->assertDatabaseHas('invoices', [
//         'id' => $invoice->id,
//         'total_price' => $invoice->total_price * 100,
//     ]);
// });

// test('price', function () {
//     $invoice = Invoice::factory()->create();

//     $this->assertDatabaseHas('invoices', [
//         'id' => $invoice->id,
//         'price' => $invoice->price * 100,
//     ]);
// });

test('formatted price', function () {
    $invoice = Invoice::factory()->price(1000)->create();

    expect($invoice->formatted_price)->toBe('1 000₽');
});

// test('formatted delivery_price', function () {
//     $invoice = Invoice::factory()->delivery_price(1000)->create();

//     expect($invoice->formatted_delivery_price)->toBe('1 000₽');
// });

// test('formatted total_price', function () {
//     $invoice = Invoice::factory()->total_price(1000)->create();

//     expect($invoice->formatted_total_price)->toBe('1 000₽');
// });
