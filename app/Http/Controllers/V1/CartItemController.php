<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Cart\CreateCartItemAction;
use App\Actions\Cart\EditCartItemAction;
use App\Http\Requests\V1\CartItem\CreateCartItemRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;

final readonly class CartItemController
{
    public function store(CreateCartItemRequest $request, CreateCartItemAction $action): ProductResource
    {
        $action->handle($request->getCart(), $request->getOption());

        return new ProductResource($request->getOption()->product);
    }

    public function edit(CartItem $cart_item, EditCartItemAction $action): JsonResponse
    {
        $action->handle($cart_item);

        return response()->json(status: 200);
    }
}
