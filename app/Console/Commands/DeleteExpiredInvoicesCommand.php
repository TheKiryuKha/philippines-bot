<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Services\BotAPIService;
use Illuminate\Console\Command;

final class DeleteExpiredInvoicesCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'delete-expired-invoices';

    /**
     * @var string
     */
    protected $description = 'It deletes expired invoices';

    public function handle(BotAPIService $service): void
    {
        $invoices = Invoice::where('expires_at', '<', now())
            ->where('status', InvoiceStatus::Created)
            ->get();

        $data = [];

        foreach ($invoices as $invoice) {
            $data['users'][] = ['chat_id' => $invoice->user->chat_id];

            $invoice->items()->delete();
            $invoice->delete();
        }

        $service->delete_invoice($data);
    }
}
