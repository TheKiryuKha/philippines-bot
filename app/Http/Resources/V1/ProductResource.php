<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Product $resource
 */
final class ProductResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'type' => 'product',
            'attributes' => [
                'title' => $this->resource->title,
                'description' => $this->resource->description,
                'price' => $this->resource->formatted_price,
                'media' => new MediaResource(
                    $this->resource->getMedia('image')->first()
                ),
            ],
        ];
    }
}
