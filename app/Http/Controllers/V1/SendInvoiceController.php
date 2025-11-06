<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Invoice\SendInvoiceAction;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;

final readonly class SendInvoiceController
{
    public function __invoke(Invoice $invoice, SendInvoiceAction $action): InvoiceResource
    {
        $action->handle($invoice);

        return new InvoiceResource($invoice);
    }
}
