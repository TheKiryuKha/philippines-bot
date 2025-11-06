<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\User;

test('to array', function () {
    $user = User::factory()->create()->refresh();

    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'created_at',
            'updated_at',
            'username',
            'chat_id',
        ]);
});

test('cart', function () {
    $cart = Cart::factory()->make();
    $user = User::factory()->create();

    $user->cart()->save($cart);

    expect($user->cart->id)->toBe($cart->id);
});
