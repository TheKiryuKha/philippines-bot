<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Product;

test('to array', function () {
    $category = Category::factory()->create()->fresh();

    expect(array_keys($category->toArray()))
        ->toBe([
            'id',
            'title',
            'created_at',
            'updated_at',
        ]);
});

it('has Products', function () {
    $product = Product::factory()->make();
    $category = Category::factory()->create();

    $category->products()->save($product);

    expect($category->products)->toHaveCount(1);
});
