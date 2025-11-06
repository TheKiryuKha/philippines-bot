<?php

declare(strict_types=1);

use App\Actions\Cart\CreateCartAction;
use App\Models\Cart;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it("save's cart for user", function () {
    $action = app(CreateCartAction::class);

    $action->handle($this->user);

    $this->assertDatabaseHas('carts', [
        'user_id' => $this->user->id,
        'products_amount' => 0,
        'price' => 0,
    ]);
});

it("return's created cart", function () {
    $action = app(CreateCartAction::class);

    $cart = $action->handle($this->user);

    expect($cart)->toBeInstanceOf(Cart::class);
});
