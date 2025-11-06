<?php

declare(strict_types=1);

use App\Models\Category;
use App\Services\CategoryCache;

beforeEach(function () {
    Category::factory(5)->create();
});

it("cache's data", function () {
    $service = app(CategoryCache::class);

    $service->cache();

    expect(Cache::has('categories'))->toBeTrue();
});

it("return's categories collection", function () {
    $service = app(CategoryCache::class);

    $categories = $service->cache();

    expect($categories->contains(Category::first()))->toBeTrue();
});
