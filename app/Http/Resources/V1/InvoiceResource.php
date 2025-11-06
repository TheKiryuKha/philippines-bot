<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Invoice $resource
 */
final class InvoiceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->resource->load('items', 'user');

        return [
            'id' => $this->resource->id,
            'type' => 'invoice',
            'attributes' => [
                'user_chat_id' => $this->resource->user->chat_id,
                'username' => $this->resource->user->username,
                'first_name' => $this->resource->first_name,
                'last_name' => $this->resource->last_name,
                'middle_name' => $this->resource->middle_name,
                'delivery_address' => $this->resource->delivery_address,
                'phone' => $this->resource->phone,
                'price' => $this->resource->price,
                'formatted_price' => $this->resource->formatted_price,
                'status' => $this->resource->status,
                'items' => CartItemResource::collection(
                    $this->resource->items
                ),
            ],
        ];
    }
}
