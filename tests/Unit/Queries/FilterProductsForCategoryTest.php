<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use App\Queries\FilterProductsForCategory;

beforeEach(function () {
    $this->category = Category::factory()->create();

    Product::factory(3)
        ->for($this->category)
        ->has(ProductOption::factory(), 'options')
        ->create();

    $this->without_options = Product::factory()
        ->for($this->category)
        ->create();
});

it("return's the list of products", function () {
    $query = app(FilterProductsForCategory::class);

    $products = $query->handle(Product::query(), $this->category);

    expect($products->get())->toHaveCount(3);
});

// it("dont return's hidden product's", function () {
//     $query = app(FilterProductsForCategory::class);

//     $products = $query->handle(Product::query(), $this->category);

//     expect($products->get())->not->toContain($this->hidden_product);
// });

it("dont return's product without options", function () {
    $query = app(FilterProductsForCategory::class);

    $products = $query->handle(Product::query(), $this->category);

    expect($products->get())->not->toContain($this->without_options);
});
