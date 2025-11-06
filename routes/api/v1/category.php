<?php

declare(strict_types=1);

use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\ProductController;

Route::get('/', [CategoryController::class, 'index'])->name('index');
Route::get('/{category}', [CategoryController::class, 'show'])->name('show');

Route::get('/{category}/products', [ProductController::class, 'index'])->name('products:index');
