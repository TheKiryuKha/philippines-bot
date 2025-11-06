<?php

declare(strict_types=1);

namespace App\Queries;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;

final readonly class FetchCreatedInvoices
{
    /**
     * @param  Builder<Invoice>  $query
     * @return Builder<Invoice>
     */
    public function handle(Builder $query): Builder
    {
        return $query
            ->where('status', InvoiceStatus::Created);
    }
}
