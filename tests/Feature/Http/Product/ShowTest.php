<?php

declare(strict_types=1);
use App\Models\Product;

beforeEach(function () {
    $this->product = Product::factory()
        ->withImage()
        ->create();
});

it("return's correct status code", function () {
    $this->get(
        route('api:v1:products:show', $this->product)
    )->assertStatus(
        200
    );
});

it("return's correct data", function () {
    $response = $this->get(route('api:v1:products:show', $this->product));

    $response->assertJsonStructure([
        'data' => [
            'id',
            'type',
            'attributes' => [
                'title',
                'description',
                'price',
                'media' => [
                    'type',
                    'image',
                ],
            ],
        ],
    ]);
});
