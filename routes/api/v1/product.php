<?php

declare(strict_types=1);

use App\Http\Controllers\V1\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::post('/', [ProductController::class, 'store'])->name('store');

Route::get('/{product}', [ProductController::class, 'show'])->name('show');
Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
