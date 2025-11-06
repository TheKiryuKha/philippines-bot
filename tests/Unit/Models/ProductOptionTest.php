<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductOption;

test('to array', function () {
    $product_option = ProductOption::factory()->create()->fresh();

    expect(array_keys($product_option->toArray()))
        ->toBe([
            'id',
            'volume',
            'price',
            'type',
            'product_id',
            'created_at',
            'updated_at',
        ]);
});

it('belongs to Product', function () {
    $product_option = ProductOption::factory()->create();

    expect($product_option->product)->toBeInstanceOf(Product::class);
});

test('setPrice', function () {
    $product_option = ProductOption::factory()->price(100)->create();

    $this->assertDatabaseHas('product_options', [
        'id' => $product_option->id,
        'price' => 100 * 100,
    ]);
});

test('getPrice', function () {
    $product_option = ProductOption::factory()->price(100)->create();

    expect($product_option->price)->toBe(100);
});

test('getFormattedPrice', function () {
    $product_option = ProductOption::factory()->price(1000)->create();

    expect($product_option->formatted_price)->toBe('1 000₽');
});
