<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductOption;

test('to array', function () {
    $cart_item = CartItem::factory()->create()->fresh();

    expect(array_keys($cart_item->toArray()))
        ->toBe([
            'id',
            'cart_id',
            'product_option_id',
            'amount',
            'created_at',
            'updated_at',
        ]);
});

it('belongs to Cart', function () {
    $cart_item = CartItem::factory()->create();

    expect($cart_item->cart)->toBeInstanceOf(Cart::class);
});

it('belongs to ProductOption', function () {
    $cart_item = CartItem::factory()->create();

    expect($cart_item->product_option)->toBeInstanceOf(ProductOption::class);
});

test('formatted price', function () {
    $cart_item = CartItem::factory()
        ->price(100)
        ->amount(3)
        ->create();

    expect($cart_item->formatted_price)->toBe('300₽');
});
