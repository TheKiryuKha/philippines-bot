<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\User;

beforeEach(function () {
    $this->option = ProductOption::factory()
        ->for(Product::factory())
        ->create();

    $this->user = User::factory()
        ->has(Cart::factory())
        ->create();

    $this->data = [
        'chat_id' => $this->user->chat_id,
        'option_id' => $this->option->id,
    ];
});

it("return's correct status code", function () {
    $this->post(
        route('api:v1:cart_items:store'), $this->data
    )->assertStatus(
        200
    );
});

it("save's cartItem in DB", function () {
    $this->post(
        route('api:v1:cart_items:store'), $this->data
    );

    $this->assertDatabaseHas('cart_items', [
        'product_option_id' => $this->data['option_id'],
        'amount' => 1,
        'cart_id' => $this->user->cart->id,
    ]);
});

it("update's cart's data", function () {
    $this->post(
        route('api:v1:cart_items:store'), $this->data
    );

    $this->assertDatabaseHas('carts', [
        'user_id' => $this->user->id,
        // цена хранится в копейках
        'price' => $this->option->price * 100,
        'products_amount' => 1,
    ]);
});

test('validation', function () {
    $this->post(
        route('api:v1:cart_items:store')
    )->assertInvalid([
        'chat_id',
        'option_id',
    ]);
});

it("don't create's already existing cart item", function () {
    Cart::first()->items()->create([
        'product_option_id' => $this->option->id,
        'amount' => 1,
    ]);

    $this->post(
        route('api:v1:cart_items:store'), $this->data
    );

    $this->assertDatabaseCount('cart_items', 1);
});

it("update's alredy existing cart item amount", function () {
    Cart::first()->items()->create([
        'product_option_id' => $this->option->id,
        'amount' => 1,
    ]);

    $this->post(
        route('api:v1:cart_items:store'), $this->data
    );

    $this->assertDatabaseHas('cart_items', [
        'product_option_id' => $this->option->id,
        'amount' => 2,
    ]);
});

it("return's correct data", function () {
    $response = $this->post(
        route('api:v1:cart_items:store'), $this->data
    );

    $response->assertJsonStructure([
        'data' => [
            'id',
            'type',
            'attributes' => [
                'title',
                'description',
                'options',
                'media',
            ],
        ],
    ]);
});
