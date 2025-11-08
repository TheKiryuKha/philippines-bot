<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Visa;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Visa $resource
 */
final class VisaResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'attributes' => [
                'expiration_time' => $this->resource->expiration_date->diffForHumans(),
                'extension_date' => $this->resource->expiration_date->translatedFormat('j F Y года'),
                'expiration_date' => $this->resource->expiration_date,
            ],
        ];
    }
}
