<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

final readonly class CreateProductAction
{
    /**
     * @param array{
     * image_link: string,
     * title: string,
     * description: string,
     * price: int,
     * } $attr
     */
    public function handle(array $attr): void
    {
        DB::transaction(function () use ($attr): void {
            $image = $attr['image_link'];
            unset($attr['image_link']);

            $product = Product::create($attr);

            $product
                ->addMediaFromUrl($image)
                ->toMediaCollection('image');
        });
    }
}
