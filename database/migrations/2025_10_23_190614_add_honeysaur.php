<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $category = Category::query()->firstOrCreate([
            'title' => 'Мёд',
        ]);

        $product = $category->products()->create([
            'title' => '«МЕДОЗАВР»',
            'description' => '<i>мёд в сотах</i>

Мёд в сотах - это первородный мёд прямо из улья, от жидкого он отличается тем, что находится внутри пчелиного дома (в пчелиных сотах). Чтобы получить уже жидкий мёд, его откачивают из таких пчелиных сот в специальном устройстве - медогонке. 

<i>Медоносы: сезонные</i>',
        ]);
        $product->addMedia(
            public_path('assets/images/medosaurus.jpg')
        )->preservingOriginal()->toMediaCollection('image');

        $product->options()->create([
            'volume' => '🫙250 мл',
            'type' => 'стекло',
            'price' => 800,
        ]);

        $product->options()->create([
            'volume' => '🫙500 мл',
            'type' => 'стекло',
            'price' => 1400,
        ]);

        $product->options()->create([
            'volume' => '🫙1000 мл',
            'type' => 'стекло',
            'price' => 2200,
        ]);
    }
};
