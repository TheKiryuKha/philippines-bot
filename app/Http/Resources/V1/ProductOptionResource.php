<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read ProductOption $resource
 */
final class ProductOptionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'type' => 'product_option',
            'attributes' => [
                'volume' => $this->resource->volume,
                'price' => $this->resource->price,
                'type' => $this->resource->type,
                'formatted_price' => $this->resource->formatted_price,
            ],
        ];
    }
}
