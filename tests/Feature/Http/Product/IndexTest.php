<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Product;

beforeEach(function () {
    $this->category = Category::factory()->create();
    Product::factory(3)
        ->for($this->category)
        ->withImage()
        ->withOptions(3)
        ->create();
});

it("return's correct status code", function () {
    $this->get(route(
        'api:v1:categories:products:index',
        $this->category
    ))->assertStatus(
        200
    );
});

it("return's correct data", function () {
    $response = $this->getJson(route(
        'api:v1:categories:products:index',
        $this->category
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
