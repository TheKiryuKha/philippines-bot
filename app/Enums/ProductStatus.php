<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductStatus: string
{
    case InStock = 'in_stock';
    case OutOfStock = 'out_of_stock';
    case Hidden = 'hidden';
}
