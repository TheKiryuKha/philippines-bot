<?php

declare(strict_types=1);

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Product::factory(3)
        ->withImage()
        ->create();
});

it("return's correct status code", function () {
    $this->get(route(
        'api:v1:products:index',
    ))->assertStatus(
        200
    );
});

it("cache's data", function () {
    $this->get(route('api:v1:products:index'));

    expect(Cache::has('products'))->toBeTrue();
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
                    'price',
                    'media' => [
                        'type',
                        'image',
                    ],
                ],
            ],
        ],
    ]);
});
