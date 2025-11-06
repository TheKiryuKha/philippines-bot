<?php

declare(strict_types=1);

use App\Http\Controllers\V1\CartItemController;

Route::post('/', [CartItemController::class, 'store'])->name('store');
Route::patch('/{cart_item}', [CartItemController::class, 'edit'])->name('edit');
