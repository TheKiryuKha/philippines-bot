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
            'title' => '«НЕФТЬ»',
            'description' => '<i>гречишный мёд</i>

Жидкое, чёрное золото. Характерный тёмный цвет, самый насыщенный вкус. Гречишный мёд обладает до 50% большей антиоксидантной активностью, чем другие виды мёда. Богат витаминами и минералами, а также отличается антимикробными свойствами. Его можно использовать как натуральный подсластитель в чае, выпечке или просто пить из трубопровода.

<i>Медоносы: гречиха</i>',
        ]);
        $product->addMedia(
            public_path('assets/images/oil.jpg')
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
