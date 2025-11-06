<?php

declare(strict_types=1);
use App\Models\Category;

it("return's correct status code", function () {
    $this->get(
        route('api:v1:categories:index')
    )->assertStatus(
        200
    );
});

it("cache's data", function () {
    $this->get(route('api:v1:categories:index'));

    expect(Cache::has('categories'))->toBeTrue();
});

it("return's correct data", function () {
    Category::factory()->create();

    $response = $this->getJson(route('api:v1:categories:index'));

    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'type',
                'attributes' => [
                    'title',
                ],
            ],
        ],
    ]);
});
