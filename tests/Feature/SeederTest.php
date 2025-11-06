<?php

declare(strict_types=1);
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

it("clear's cache before seeding data", function () {
    Cache::remember('categories', 3600, fn () => Category::all());

    $this->artisan('db:seed');

    expect(Cache::has('categories'))->toBeFalse();
});
