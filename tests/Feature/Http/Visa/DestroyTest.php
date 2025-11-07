<?php

declare(strict_types=1);
use App\Models\Visa;

it("return's correct status code", function () {
    $this->delete(
        route('api:v1:visas:destroy', Visa::factory()->create()->id)
    )->assertStatus(
        204
    );
});

it("delete's Visa", function () {
    $visa = Visa::factory()->create();

    $this->delete(route('api:v1:visas:destroy', $visa->id));

    $this->assertDatabaseEmpty('visas');
});
