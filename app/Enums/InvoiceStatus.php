<?php

declare(strict_types=1);

namespace App\Enums;

enum InvoiceStatus: string
{
    case Created = 'created';
    case Paid = 'paid';
    case Sent = 'sent';
}
