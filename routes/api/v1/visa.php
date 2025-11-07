<?php

declare(strict_types=1);

use App\Http\Controllers\V1\VisaController;

Route::post('/', [VisaController::class, 'store'])->name('store');
Route::patch('/{user:chat_id}', [VisaController::class, 'update'])->name('update');
