<?php

declare(strict_types=1);

namespace App\Actions\Invoice;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;

final readonly class PayInvoiceAction
{
    public function handle(Invoice $invoice): Invoice
    {
        $invoice->update(['status' => InvoiceStatus::Paid]);

        return $invoice;
    }
}
