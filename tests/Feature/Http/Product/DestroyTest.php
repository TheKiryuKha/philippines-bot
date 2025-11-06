<?php

declare(strict_types=1);
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

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

it("delete's product's from cart's", function () {
    $product = Product::factory()->inCart()->create();
    Log::info(CartItem::all());

    $this->delete(route('api:v1:products:destroy', $product));

    Log::info(CartItem::all());
    $this->assertDatabaseCount('cart_items', 0);
});

it("update's cart data after removing product from it", function () {
    $product = Product::factory()->inCart()->create();

    $this->delete(route('api:v1:products:destroy', $product));

    $this->assertDatabaseHas('carts', [
        'id' => Cart::first()->id,
        'products_amount' => 0,
        'price' => 0,
    ]);
});
