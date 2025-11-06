<?php

declare(strict_types=1);
use App\Models\Cart;
use App\Models\Product;

it("return's correct status code", function () {
    $this->delete(
        route('api:v1:products:destroy', Product::factory()->create())
    )->assertStatus(
        204
    );
});

it("delete's product", function () {
    $product = Product::factory()->create();

    $this->delete(route('api:v1:products:destroy', $product));

    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

it("delete's product options", function () {
    $product = Product::factory()->withOptions(3)->create();
    $option_id = $product->options()->first()->id;

    $this->delete(route('api:v1:products:destroy', $product));

    $this->assertDatabaseMissing('product_options', ['id' => $option_id]);
});

it("delete's product's from cart's", function () {
    $product = Product::factory()->withOptions(3)->inCart()->create();

    $this->delete(route('api:v1:products:destroy', $product));

    $this->assertDatabaseCount('cart_items', 0);
});

it("update's cart data after removing product from it", function () {
    $product = Product::factory()->withOptions(3)->inCart()->create();

    $this->delete(route('api:v1:products:destroy', $product));

    $this->assertDatabaseHas('carts', [
        'id' => Cart::first()->id,
        'products_amount' => 0,
        'price' => 0,
    ]);
});
