<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Visa;
use Carbon\CarbonImmutable;

test('to array', function () {
    $visa = Visa::factory()->create()->fresh();

    expect(array_keys($visa->toArray()))
        ->toBe([
            'id',
            'user_id',
            'expiration_date',
            'created_at',
            'updated_at',
        ]);
});

test('setDate', function () {
    $visa = Visa::factory()->expiration_date('03.10.2025')->create();

    $this->assertDatabaseHas('visas', [
        'id' => $visa->id,
        'expiration_date' => '2025-10-03',
    ]);
});

test('getDate', function () {
    $visa = Visa::factory()->expiration_date('03.10.2025')->create();

    expect($visa->expiration_date)->toBeInstanceOf(CarbonImmutable::class);
});

test('user', function () {
    $visa = Visa::factory()->create();

    expect($visa->user)->toBeInstanceOf(User::class);
});
