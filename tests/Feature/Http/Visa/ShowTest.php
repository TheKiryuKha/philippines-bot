<?php

declare(strict_types=1);

use App\Models\Visa;

it("return's correct status code", function () {
    $this->get(
        route('api:v1:users:get_visa', Visa::factory()->create()->user->chat_id)
    )->assertStatus(
        200
    );
});

it("return's correct data format", function () {
    $visa = Visa::factory()->create();

    $response = $this->get(route('api:v1:users:get_visa', $visa->user->chat_id));

    $response->assertJsonStructure([
        'data' => [
            'id',
            'attributes' => [
                'expiration_date',
            ],
        ],
    ]);
});
