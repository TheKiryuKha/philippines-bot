<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Resources\V1\InvoiceResource;
use App\Models\User;

final readonly class GetUserInvoiceController
{
    public function __invoke(User $user): InvoiceResource
    {
        return new InvoiceResource($user->invoices()->first());
    }
}
