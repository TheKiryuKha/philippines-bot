<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\CartItem;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read CartItem|InvoiceItem $resource
 */
final class CartItemResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->resource->load('product');

        $product = $this->resource->product;

        return [
            'id' => $this->resource->id,
            'attributes' => [
                'amount' => $this->resource->amount,
                'title' => $product->title,
                'description' => $product->description,
                'product_id' => $product->id,
                'price' => $product->price,
                'formatted_price' => $product->formatted_price,
                'total_price' => $this->resource->formatted_price,
            ],
        ];
    }
}
