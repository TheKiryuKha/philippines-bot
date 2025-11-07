<?php

declare(strict_types=1);

use App\Models\User;

it("return's correct status code", function () {
    $user = User::factory()->create();

    $this->post(route('api:v1:visas:store'), [
        'user_id' => $user->id,
        'expiration_date' => '03.11.2025',
    ])
        ->assertStatus(201);
});

it("save's visa in DB", function () {
    $user = User::factory()->create();

    $this->post(route('api:v1:visas:store'), [
        'user_id' => $user->id,
        'expiration_date' => '03.11.2025',
    ]);

    $this->assertDatabaseHas('visas', [
        'expiration_date' => '2025-11-03',
    ]);
});

test('user can have only 1 visa');

test('validation', function () {
    $this->post(
        route('api:v1:visas:store')
    )->assertInvalid([
        'expiration_date',
        'user_id',
    ]);
});
