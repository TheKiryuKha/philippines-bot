<?php

declare(strict_types=1);

use App\Http\Controllers\V1\GetInvoiceCitiesController;
use App\Http\Controllers\V1\InvoiceController;
use App\Http\Controllers\V1\PayInvoiceController;
use App\Http\Controllers\V1\SendInvoiceController;

Route::get('/', [InvoiceController::class, 'index'])->name('index');
Route::post('/', [InvoiceController::class, 'store'])->name('store');

Route::patch('/{invoice}/pay', PayInvoiceController::class)->name('pay');
Route::patch('/{invoice}/send', SendInvoiceController::class)->name('send');

Route::get('/get_cities', GetInvoiceCitiesController::class)->name('get_cities');
