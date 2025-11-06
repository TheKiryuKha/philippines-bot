<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $category = Category::query()->firstOrCreate([
            'title' => 'Прополисный Холстик',
        ]);

        $product = $category->products()->create([
            'title' => '«ХОЛСТИК»',
            'description' => '<i>прополисный холст</i>

+аура вашего жилища ',
        ]);
        $product->addMedia(
            public_path('assets/images/canvas.jpg')
        )->preservingOriginal()->toMediaCollection('image');

        $product->options()->create([
            'volume' => '1 шт',
            'type' => 'прополис',
            'price' => 1700,
        ]);
    }
};
