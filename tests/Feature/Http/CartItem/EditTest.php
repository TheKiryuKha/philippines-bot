<?php

declare(strict_types=1);

use App\Models\Cart;

beforeEach(function () {
    $this->item = Cart::factory()
        ->withItem(2)
        ->create()
        ->items->first();
});

it("return's correct status code", function () {
    $this->patch(
        route('api:v1:cart_items:edit', $this->item)
    )->assertStatus(
        200
    );
});

it("update's item's amount", function () {
    $this->patch(route('api:v1:cart_items:edit', $this->item));

    $this->assertDatabaseHas('cart_items', [
        'product_option_id' => $this->item->product_option_id,
        'amount' => 1,
    ]);
});

it("update's cart's data", function () {
    $this->patch(route('api:v1:cart_items:edit', $this->item));

    $this->assertDatabaseHas('carts', [
        'id' => $this->item->cart_id,
        'products_amount' => 1,
        'price' => $this->item->product_option->price * 100,
    ]);
});

it("delete's item if amount is 0", function () {
    $item = Cart::factory()
        ->withItem(1)
        ->create()
        ->items()->first();

    $this->patch(route('api:v1:cart_items:edit', $item));

    $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);
});

it("update's cart's data after deleting item", function () {
    $item = Cart::factory()
        ->withItem(1)
        ->create()
        ->items()->first();

    $this->patch(route('api:v1:cart_items:edit', $item));

    $this->assertDatabaseHas('carts', [
        'id' => $item->cart_id,
        'products_amount' => 0,
        'price' => 0,
    ]);
});
