<?php

declare(strict_types=1);

use App\Models\Product;

test('to array', function () {
    $product = Product::factory()->create()->fresh();

    expect(array_keys($product->toArray()))
        ->toBe([
            'id',
            'title',
            'description',
            'price',
            'created_at',
            'updated_at',
        ]);
});

test('set price', function () {
    $product = Product::factory()->price(1000)->create();

    $this->assertDatabaseHas('products', ['price' => 100000]);
});

test('get price', function () {
    $product = Product::factory()->price(1000)->create();

    expect($product->price)->toBe(1000);
});

test('get formatted price', function () {
    $product = Product::factory()->price(1000)->create();

    expect($product->formatted_price)->toBe('1 000₽');
});

test("media collectoin's", function () {
    $product = Product::factory()->create();

    $is_exists = $product
        ->getRegisteredMediaCollections()
        ->contains('name', 'image');

    expect($is_exists)->toBeTrue();
});
