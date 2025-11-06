<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\User;

final readonly class CreateCartAction
{
    public function handle(User $user): Cart
    {
        return $user->cart()->create([
            'products_amount' => 0,
            'price' => 0,
        ]);
    }
}
