<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Invoice\CreateInvoiceAction;
use App\Http\Requests\V1\Invoice\CreateInvoiceRequest;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use App\Queries\FetchInvoices;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class InvoiceController
{
    public function index(FetchInvoices $query): AnonymousResourceCollection
    {
        $invoices = $query->handle(Invoice::query());

        return InvoiceResource::collection($invoices->get());
    }

    public function store(CreateInvoiceRequest $request, CreateInvoiceAction $action): InvoiceResource
    {
        $invoice = $action->handle($request->validated());

        return new InvoiceResource($invoice);
    }
}
