<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $cart_id
 * @property-read int $product_option_id
 * @property-read int $amount
 * @property-read string $formatted_price
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read Cart $cart
 * @property-read ProductOption $product_option
 */
final class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Cart, $this>
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * @return BelongsTo<ProductOption, $this>
     */
    public function product_option(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format(
            num: $this->product_option->price * $this->amount,
            thousands_separator: ' '
        ).'₽';
    }
}
