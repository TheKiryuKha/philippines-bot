<?php

declare(strict_types=1);
use App\Models\User;

it("return's correct status code", function () {
    $user = User::factory()->withInvoice()->create();

    $this->get(
        route('api:v1:users:get_invoice', $user->chat_id)
    )
        ->assertStatus(200);
});

it("return's correct data", function () {
    $user = User::factory()->withInvoice()->create();

    $response = $this->get(
        route('api:v1:users:get_invoice', $user->chat_id)
    );

    $response->assertJsonStructure([
        'data' => [
            'id',
            'type',
            'attributes' => [
                'user_chat_id',
                'username',
                'first_name',
                'last_name',
                'middle_name',
                'delivery_address',
                'phone',
                'price',
                'formatted_price',
                'items' => [
                    '*' => [
                        'id',
                        'attributes' => [
                            'amount',
                            'title',
                            'description',
                            'honey_plants',
                            'option_id',
                            'volume',
                            'price',
                            'formatted_price',
                            'total_price',
                            'type',
                        ],
                    ],
                ],
            ],
        ],
    ]);
});
