<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final readonly class FilterUsers
{
    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function handle(Builder $query): Builder
    {
        return QueryBuilder::for(
            $query
        )->allowedFilters([
            AllowedFilter::exact('chat_id'),
        ])->getEloquentBuilder();
    }
}
