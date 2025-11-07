<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\User;
use App\Models\Visa;

test('to array', function () {
    $user = User::factory()->create()->refresh();

    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'username',
            'chat_id',
            'created_at',
            'updated_at',
        ]);
});

test('cart', function () {
    $cart = Cart::factory()->make();
    $user = User::factory()->create();

    $user->cart()->save($cart);

    expect($user->cart->id)->toBe($cart->id);
});

test('visa', function () {
    $visa = Visa::factory()->make();
    $user = User::factory()->create();

    $user->visa()->save($visa);

    expect($user->visa->id)->toBe($visa->id);
});
