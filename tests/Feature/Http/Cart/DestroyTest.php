<?php

declare(strict_types=1);
use App\Models\Cart;

beforeEach(function () {
    $this->cart = Cart::factory()
        ->withItem(2)
        ->create();
});

it("return's correct status code", function () {
    $this->delete(
        route('api:v1:carts:destroy', $this->cart)
    )->assertStatus(
        200
    );
});

it("delete's items from DB", function () {
    $this->delete(route('api:v1:carts:destroy', $this->cart));

    $this->assertDatabaseCount('cart_items', 0);
});

it("decrease's cart's data to 0", function () {
    $this->delete(route('api:v1:carts:destroy', $this->cart));

    $this->assertDatabaseHas('carts', [
        'id' => $this->cart->id,
        'products_amount' => 0,
        'price' => 0,
    ]);
});
