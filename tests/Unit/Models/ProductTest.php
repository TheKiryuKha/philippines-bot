<?php

declare(strict_types=1);

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;

test('to array', function () {
    $product = Product::factory()->create()->fresh();

    expect(array_keys($product->toArray()))
        ->toBe([
            'id',
            'title',
            'description',
            'category_id',
            'created_at',
            'updated_at',
        ]);
});

// test('status', function () {
//     $product = Product::factory()->create();

//     expect($product->status)
//         ->toBeInstanceOf(ProductStatus::class);
// });

it('belongs to Category', function () {
    $product = Product::factory()->create();

    expect($product->category)->toBeInstanceOf(Category::class);
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
