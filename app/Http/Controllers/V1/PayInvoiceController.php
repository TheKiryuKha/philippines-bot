<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Invoice\PayInvoiceAction;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;

final readonly class PayInvoiceController
{
    public function __invoke(Invoice $invoice, PayInvoiceAction $action): InvoiceResource
    {
        $action->handle($invoice);

        return new InvoiceResource($invoice);
    }
}
