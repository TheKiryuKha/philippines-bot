<?php

declare(strict_types=1);

namespace App\Models\Traits;

trait HasPrice
{
    public function setPriceAttribute(int $value): void
    {
        $this->attributes['price'] = round($value * 100);
    }

    public function getPriceAttribute(int $value): int
    {
        return $value / 100;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format(
            num: $this->price,
            thousands_separator: ' '
        ).'₽';
    }

    // public function setDeliveryPriceAttribute(int $value): void
    // {
    //     $this->attributes['delivery_price'] = round($value * 100);
    // }

    // public function getDeliveryPriceAttribute(int $value): int
    // {
    //     return $value / 100;
    // }

    // public function getFormattedDeliveryPriceAttribute(): string
    // {
    //     return number_format(
    //         num: $this->delivery_price,
    //         thousands_separator: ' '
    //     ).'₽';
    // }

    // public function setTotalPriceAttribute(int $value): void
    // {
    //     $this->attributes['total_price'] = round($value * 100);
    // }

    // public function getTotalPriceAttribute(int $value): int
    // {
    //     return $value / 100;
    // }

    // public function getFormattedTotalPriceAttribute(): string
    // {
    //     return number_format(
    //         num: $this->total_price,
    //         thousands_separator: ' '
    //     ).'₽';
    // }
}
