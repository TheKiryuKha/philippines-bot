<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $category = Category::query()->firstOrCreate([
            'title' => 'Забрус',
        ]);

        $product = $category->products()->create([
            'title' => '«ЗАБРУС»',
            'description' => '<i>медовая печатка</i>

Снимает бактериальную, инфекционную нагрузку, насыщая кровь противомикробными веществами.

Очищает дёсны, язык и щеки лучше зубной щетки.

Процесс жевания снижает уровень кортизола.

<i>Медоносы: сезонные.</i>',
        ]);
        $product->addMedia(
            public_path('assets/images/lining.jpg')
        )->preservingOriginal()->toMediaCollection('image');

        $product->options()->create([
            'volume' => '🫙250 мл',
            'type' => 'стекло',
            'price' => 500,
        ]);

        $product->options()->create([
            'volume' => '🫙500 мл',
            'type' => 'стекло',
            'price' => 1000,
        ]);

        $product->options()->create([
            'volume' => '🫙1000 мл',
            'type' => 'стекло',
            'price' => 1800,
        ]);
    }
};
