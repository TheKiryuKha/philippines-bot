<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

final readonly class FilterProductsForCategory
{
    /**
     * @param  Builder<Product>  $query
     * @return Builder<Product>
     */
    public function handle(Builder $query, Category $category): Builder
    {
        return $query
            ->where('category_id', $category->id)
            ->has('options')
            ->with('options');
    }
}
