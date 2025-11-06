<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read Media $resource
 */
final class MediaResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var string $file_contents */
        $file_contents = file_get_contents($this->resource->getPath());

        $image = base64_encode($file_contents);

        return [
            'type' => $this->resource->type,
            'image' => $image,
        ];
    }
}
