<?php

declare(strict_types=1);

use App\Models\Visa;

it("return's correct status code", function () {
    $visa = Visa::factory()->create();

    $this->patch(
        route('api:v1:visas:update', $visa->user->chat_id),
    )->assertStatus(
        200
    );
});

it("extend's visa", function () {
    $visa = Visa::factory()->expiration_date('20.03.2026')->create();

    $this->patch(route('api:v1:visas:update', $visa->user->chat_id));

    $this->assertDatabaseHas('visas', [
        'id' => $visa->id,
        'expiration_date' => '2026-04-20',
    ]);
});
