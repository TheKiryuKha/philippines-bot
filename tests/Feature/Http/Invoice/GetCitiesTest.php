<?php

declare(strict_types=1);

it("return's correct status code", function () {
    $this->get(
        route('api:v1:invoices:get_cities', ['city' => 'Гомель'])
    )->assertStatus(
        200
    );
});

it("return's correct data format", function () {
    $this->get(
        route('api:v1:invoices:get_cities', ['city' => 'Гомель'])
    )
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'city',
                    'code',
                ],
            ],
        ]);
});

test('validation', function () {
    $this->get(
        route('api:v1:invoices:get_cities')
    )->assertInvalid([
        'city',
    ]);
});
