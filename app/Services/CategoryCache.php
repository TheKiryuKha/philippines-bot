<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final readonly class CategoryCache
{
    private const string KEY = 'categories';

    /**
     * @return Collection<int, Category>
     */
    public function cache(): Collection
    {
        /** @var Collection<int, Category> */
        $categories = Cache::remember(self::KEY, 86400, fn () => Category::all());

        return $categories;
    }

    public function forget(): void
    {
        Cache::forget(self::KEY);
    }
}
