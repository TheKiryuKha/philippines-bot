<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final readonly class ProductCacheService
{
    private const string KEY = 'products';

    /**
     * @return ?Collection<int, Product>
     */
    public function get_cache(): ?Collection
    {
        /** @var ?Collection<int, Product> $products */
        $products = Cache::remember($this::KEY, 86400, Product::all(...));

        return $products;
    }

    public function clear(): void
    {
        Cache::forget($this::KEY);
    }
}
