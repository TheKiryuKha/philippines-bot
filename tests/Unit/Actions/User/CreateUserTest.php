<?php

declare(strict_types=1);

use App\Actions\User\CreateUserAction;
use App\Models\User;

beforeEach(function () {
    $this->data = [
        'chat_id' => 1,
        'username' => 'mr_TheKiryuKha',
    ];
});

it("save's user's data in DB", function () {
    $action = app(CreateUserAction::class);

    $action->handle($this->data);

    $this->assertDatabaseHas('users', $this->data);
});

it("return's created user", function () {
    $action = app(CreateUserAction::class);

    $user = $action->handle($this->data);

    expect($user)->toBeInstanceOf(User::class);
});

it("save's cart for user", function () {
    $action = app(CreateUserAction::class);

    $action->handle($this->data);

    $this->assertDatabaseHas('carts', [
        'user_id' => User::first()->id,
        'products_amount' => 0,
        'price' => 0,
    ]);
});
