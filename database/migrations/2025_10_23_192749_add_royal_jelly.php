<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $category = Category::query()->firstOrCreate([
            'title' => 'Маточное молочко',
        ]);

        $product = $category->products()->create([
            'title' => '«МАТОЧНОЕ МОЛОЧКО»',
            'description' => '<i>корм для маток пчел (королевский корм)</i>

Маточное молочко - единственный продукт, содержащий белок MRJP (роялактин) - будит спящие стволовые клетки и побуждает их к делению (медленное старение).',
        ]);
        $product->addMedia(
            public_path('assets/images/royal_jelly.jpg')
        )->preservingOriginal()->toMediaCollection('image');

        $product->options()->create([
            'volume' => '🫙8 грамм',
            'type' => 'МЕСЯЧНЫЙ КУРС',
            'price' => 7320,
        ]);

        $product->options()->create([
            'volume' => '🫙24 грамма',
            'type' => 'ГОДОВОЙ КУРС',
            'price' => 13270,
        ]);
    }
};
