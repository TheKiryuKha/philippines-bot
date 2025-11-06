<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final readonly class FetchInvoices
{
    /**
     * @param  Builder<Invoice>  $query
     * @return Builder<Invoice>
     */
    public function handle(Builder $query): Builder
    {
        return QueryBuilder::for(
            $query
        )->allowedFilters([
            AllowedFilter::exact('status'),
        ])->getEloquentBuilder();
    }
}
