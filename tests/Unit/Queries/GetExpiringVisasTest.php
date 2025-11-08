<?php

declare(strict_types=1);

use App\Models\Visa;
use App\Queries\GetExpiringVisas;

it("return's expiring visas", function () {
    Visa::factory()->expiries_in_two_weeks()->create();
    Visa::factory()->expiries_in_week()->create();
    Visa::factory()->expiries_in_one_day()->create();
    $query = app(GetExpiringVisas::class);

    $visas = $query->handle();

    expect($visas->count())->toBe(3);
});
