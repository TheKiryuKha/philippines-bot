<?php

declare(strict_types=1);

Route::prefix('products')->as('products:')->group(
    base_path('routes/api/v1/product.php')
);

Route::prefix('users')->as('users:')->group(
    base_path('routes/api/v1/user.php')
);

Route::prefix('cart_items')->as('cart_items:')->group(
    base_path('routes/api/v1/cart_item.php')
);

Route::prefix('carts')->as('carts:')->group(
    base_path('routes/api/v1/cart.php')
);

Route::prefix('invoices')->as('invoices:')->group(
    base_path('routes/api/v1/invoice.php')
);
