<?php

declare(strict_types=1);

use App\Models\Product;

beforeEach(function () {
    Product::factory(3)
        ->withImage()
        ->withOptions(3)
        ->create();
});

it("return's correct status code", function () {
    $this->get(route(
        'api:v1:products:index',
    ))->assertStatus(
        200
    );
});

it("return's correct data", function () {
    $response = $this->getJson(route(
        'api:v1:products:index',
    ));

    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'type',
                'attributes' => [
                    'title',
                    'description',
                    'options' => [
                        '*' => [
                            'id',
                            'type',
                            'attributes' => [
                                'volume',
                                'price',
                                'type',
                                'formatted_price',
                            ],
                        ],
                    ],
                    'media' => [
                        'type',
                        'image',
                    ],
                ],
            ],
        ],
    ]);
});
