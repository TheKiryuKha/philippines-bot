<?php

declare(strict_types=1);

use App\Models\Category;

beforeEach(function () {
    $this->category = Category::factory()->create();
});

it("return's correct status code", function () {
    $this->get(
        route('api:v1:categories:show', $this->category)
    )->assertStatus(
        200
    );
});

it("return's correct data", function () {
    $response = $this->get(
        route('api:v1:categories:show', $this->category)
    );

    $response->assertJsonStructure([
        'data' => [
            'id',
            'type',
            'attributes' => [
                'title',
            ],
        ],
    ]);
});
