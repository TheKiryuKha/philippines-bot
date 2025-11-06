<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('api')->as('api:')->group(function () {
    /**
     * V1
     */
    Route::prefix('v1')->as('v1:')->group(
        base_path('routes/api/v1/v1.php')
    );
});
