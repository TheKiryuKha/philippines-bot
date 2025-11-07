<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property-read CarbonInterface $expiration_date
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read User $user
 */
final class Visa extends Model
{
    /** @use HasFactory<\Database\Factories\VisaFactory> */
    use HasFactory;

    /**
     * @return Attribute<CarbonInterface|null, string|null>
     */
    public function expirationDate(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value): ?CarbonInterface => $value ? Carbon::createFromFormat('d.m.Y', $value) : null,
        );
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'expiration_date' => 'date',
        ];
    }
}
