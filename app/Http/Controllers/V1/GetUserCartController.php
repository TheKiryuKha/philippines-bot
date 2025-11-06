<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Resources\V1\CartResource;
use App\Models\User;
use App\Queries\FilterCarts;

final readonly class GetUserCartController
{
    public function __invoke(User $user, FilterCarts $query): CartResource
    {
        $cart = $query->handle(
            $user->cart()->getQuery()
        );

        return new CartResource($cart->first());
    }
}
