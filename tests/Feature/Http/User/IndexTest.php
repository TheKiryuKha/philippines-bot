<?php

declare(strict_types=1);

use App\Models\User;

it("return's correct status code", function () {
    $this->get(
        route('api:v1:users:index')
    )->assertStatus(
        200
    );
});

it("return's correct data", function () {
    $response = $this->get(route('api:v1:users:index'));

    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'type',
                'attributes' => [
                    'username',
                    'chat_id',
                ],
            ],
        ],
    ]);
});

test('filter by chat_id', function () {
    $user = User::factory(2)->create()->first();

    $response = $this->get(
        route('api:v1:users:index')."?filter[chat_id]={$user->chat_id}"
    );

    $response->assertJsonFragment([
        'chat_id' => $user->chat_id,
    ]);

    expect($response->json()['data'])->toHaveCount(1);
});
