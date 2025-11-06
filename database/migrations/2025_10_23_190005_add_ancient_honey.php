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
            'title' => '«ДРЕВНИЙ МЁД»',
            'description' => '<i>липовый мёд</i>

Боржоми - это не только бутылка минералки. Самый старый 5500-летний мед был найден на месте захоронения именно в городе Боржоми (Грузия), а не в Египте. В разграбленной гробнице обнаружили керамические сосуды с остатками меда, ритуально оставленным для будущих загробных трапез. По результатам биологического анализа мёд был липовым.

<i>Медоносы: липа</i>',
        ]);
        $product->addMedia(
            public_path('assets/images/ancient.jpg')
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
