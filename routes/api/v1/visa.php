<?php

declare(strict_types=1);

use App\Http\Controllers\V1\VisaController;

Route::post('/', [VisaController::class, 'store'])->name('store');
Route::patch('/{visa}', [VisaController::class, 'update'])->name('update');

Route::delete('/{visa}', [VisaController::class, 'destroy'])->name('destroy');
