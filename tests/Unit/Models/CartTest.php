<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;

test('to array', function () {
    $cart = Cart::factory()->create();

    expect(array_keys($cart->toArray()))
        ->toBe([
            'user_id',
            'products_amount',
            'price',
            'updated_at',
            'created_at',
            'id',
        ]);
});

test('setPrice', function () {
    $cart = Cart::factory()->price(100)->create();

    $this->assertDatabaseHas('carts', [
        'id' => $cart->id,
        'price' => 100 * 100,
    ]);
});

test('getPrice', function () {
    $cart = Cart::factory()->price(100)->create();

    expect($cart->price)->toBe(100);
});

test('getFormattedPrice', function () {
    $cart = Cart::factory()->price(1000)->create();

    expect($cart->formatted_price)->toBe('1 000₽');
});

it('has items', function () {
    $item = CartItem::factory()->make();
    $cart = Cart::factory()->create();

    $cart->items()->save($item);

    expect($cart->items)->toHaveCount(1);
});

test('getByChatId', function () {
    Cart::factory()->for(
        User::factory()->chat_id(1)
    )->create();

    $cart = Cart::getByChatId(1);

    expect($cart)->toBeInstanceOf(Cart::class);
});
