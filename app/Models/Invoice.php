<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\InvoiceStatus;
use App\Models\Traits\HasPrice;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read InvoiceStatus $status
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read string $middle_name
 * @property-read string $delivery_address
 * @property-read string $phone
 * @property-read int $price
 * @property-read int $user_id
 * @property-read int $delivery_price
 * @property-read int $total_price
 * @property-read string $formatted_price
 * @property-read string $formatted_delivery_price
 * @property-read string $formatted_total_price
 * @property-read CarbonInterface $expires_at
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read User $user
 * @property-read Collection<int, InvoiceItem> $items
 */
final class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;

    use HasPrice;

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<InvoiceItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'status' => InvoiceStatus::class,
        ];
    }
}
