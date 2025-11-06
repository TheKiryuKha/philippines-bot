<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Cart\DeleteCartAction;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;

final readonly class CartController
{
    public function destroy(Cart $cart, DeleteCartAction $action): JsonResponse
    {
        $action->handle($cart);

        return response()->json(status: 200);
    }
}
