<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Cart $resource
 */
final class CartResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'type' => 'cart',
            'attributes' => [
                'products_amount' => $this->resource->products_amount,
                'price' => $this->resource->price,
                'formatted_price' => $this->resource->formatted_price,
                'items' => CartItemResource::collection(
                    $this->whenLoaded('items')
                ),
            ],
        ];
    }
}
