<?php

declare(strict_types=1);
use App\Http\Controllers\V1\CartController;

Route::delete('/{cart}', [CartController::class, 'destroy'])->name('destroy');
