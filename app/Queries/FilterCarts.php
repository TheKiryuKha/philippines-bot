<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

final readonly class FilterCarts
{
    /**
     * @param  Builder<Cart>  $query
     * @return Builder<Cart>
     */
    public function handle(Builder $query): Builder
    {
        return QueryBuilder::for(
            $query
        )->allowedIncludes(
            ['items']
        )->getEloquentBuilder();
    }
}
