<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Product\CreateProductAction;
use App\Actions\Product\DeleteProductAction;
use App\Http\Requests\V1\Product\CreateProductRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Queries\FilterProductsForCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class ProductController
{
    public function index(Category $category, FilterProductsForCategory $query): AnonymousResourceCollection
    {
        $products = $query->handle(Product::query(), $category);

        return ProductResource::collection($products->get());
    }

    public function store(CreateProductRequest $request, CreateProductAction $action): JsonResponse
    {
        $action->handle($request->validated());

        return response()->json(status: 201);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function destroy(Product $product, DeleteProductAction $action): JsonResponse
    {
        $action->handle($product);

        return response()->json(status: 204);
    }
}
