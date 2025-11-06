<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductOption;

test('to array', function () {
    $product = Product::factory()->create()->fresh();

    expect(array_keys($product->toArray()))
        ->toBe([
            'id',
            'title',
            'description',
            'created_at',
            'updated_at',
        ]);
});

it('has options', function () {
    $option = ProductOption::factory()->make();
    $product = Product::factory()->create();

    $product->options()->save($option);

    expect($product->options)->toHaveCount(1);
});

test("media collectoin's", function () {
    $product = Product::factory()->create();

    $is_exists = $product
        ->getRegisteredMediaCollections()
        ->contains('name', 'image');

    expect($is_exists)->toBeTrue();
});
