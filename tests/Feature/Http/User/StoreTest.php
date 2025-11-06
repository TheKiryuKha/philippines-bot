<?php

declare(strict_types=1);
use App\Models\User;

beforeEach(function () {
    $this->data = [
        'chat_id' => 1,
        'username' => 'mr_TheKiryuKha',
    ];
});

it("return's correct statsu code", function () {
    $this->post(
        route('api:v1:users:store'), $this->data
    )->assertStatus(
        201
    );
});

test('validation', function () {
    $this->post(
        route('api:v1:users:store')
    )->assertInvalid([
        'chat_id',
        'username',
    ]);
});

it("save's users data in DB", function () {
    $this->post(route('api:v1:users:store'), $this->data);

    $this->assertDatabaseHas('users', $this->data);
});

it("save's cart for user", function () {
    $this->post(route('api:v1:users:store'), $this->data);

    $this->assertDatabaseHas('carts', [
        'user_id' => User::first()->id,
        'products_amount' => 0,
        'price' => 0,
    ]);
});
