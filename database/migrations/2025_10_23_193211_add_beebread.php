<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $category = Category::query()->firstOrCreate([
            'title' => 'Перга',
        ]);

        $product = $category->products()->create([
            'title' => '«ПЕРГА»',
            'description' => '<i>пчелиный корм</i>

Консервированная перга в меду, объединяющая в себе полезные свойства сразу двух продуктов пчеловодства. Углеводно-белковая смесь.

Перга - переработанная пчелами пыльца, прошедшая процесс молочнокислого брожения в сотах. Полезна для сердечно сосудистой системы.',
        ]);
        $product->addMedia(
            public_path('assets/images/beebread.jpg')
        )->preservingOriginal()->toMediaCollection('image');

        $product->options()->create([
            'volume' => '🫙100 гр',
            'type' => 'консервированная',
            'price' => 900,
        ]);

        $product->options()->create([
            'volume' => '🫙1 000 гр',
            'type' => 'консервированная',
            'price' => 5500,
        ]);
    }
};
