<?php

declare(strict_types=1);

use App\Models\Category;
use App\Services\CategoryCache;
use Illuminate\Support\Facades\Cache;

it("forget's categories cache", function () {
    Cache::remember('categories', 1000, fn () => Category::factory()->create());
    $service = app(CategoryCache::class);

    $service->forget();

    expect(Cache::has('categories'))->toBeFalse();
});
