<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasPrice;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read string $volume
 * @property-read int $price
 * @property-read string $type
 * @property-read int $weight
 * @property-read int $product_id
 * @property-read string $formatted_price
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read Product $product
 * @property-read Collection<int, CartItem> $cart_items
 */
final class ProductOption extends Model
{
    /** @use HasFactory<\Database\Factories\ProductOptionFactory> */
    use HasFactory;

    use HasPrice;

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return HasMany<CartItem, $this>
     */
    public function cart_items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
