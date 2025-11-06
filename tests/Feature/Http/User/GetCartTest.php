<?php

declare(strict_types=1);
use App\Models\User;

it("return's correct status code", function () {
    $this->get(route(
        'api:v1:users:get_cart',
        User::factory()->withCart()->create()->chat_id
    ))->assertStatus(
        200
    );
});

it("return's correct data", function () {
    $user = User::factory()->withCart()->create();

    $response = $this->get(route('api:v1:users:get_cart', $user->chat_id));

    $response->assertJsonStructure([
        'data' => [
            'id',
            'type',
            'attributes' => [
                'products_amount',
                'price',
                'formatted_price',
            ],
        ],
    ]);
});

test('include items', function () {
    $user = User::factory()->withCart(1)->create();

    $response = $this->get(
        route('api:v1:users:get_cart', $user->chat_id)
        .'?include=items'
    );

    $response->assertJsonStructure([
        'data' => [
            'id',
            'type',
            'attributes' => [
                'products_amount',
                'price',
                'formatted_price',
                'items' => [
                    '*' => [
                        'id',
                        'attributes' => [
                            'title',
                            'description',
                            'price',
                            'formatted_price',
                        ],
                    ],
                ],
            ],
        ],
    ]);
});
