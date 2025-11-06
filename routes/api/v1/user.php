<?php

declare(strict_types=1);

use App\Http\Controllers\V1\GetUserCartController;
use App\Http\Controllers\V1\GetUserInvoiceController;
use App\Http\Controllers\V1\UserController;

Route::get('/', [UserController::class, 'index'])->name('index');
Route::post('/', [UserController::class, 'store'])->name('store');

Route::get('/{user:chat_id}/cart', GetUserCartController::class)->name('get_cart');
Route::get('/{user:chat_id}/invoice', GetUserInvoiceController::class)->name('get_invoice');
