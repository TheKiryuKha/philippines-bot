<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $category = Category::query()->firstOrCreate([
            'title' => 'Пыльца',
        ]);

        $product = $category->products()->create([
            'title' => '«ПЫЛЬЦА ЧЁРНОГО МЕЧНИКА»',
            'description' => '<i>пчелиная пыльца (обножка)</i>

Пыльца с крыльев южных эльфов не горчит и обладает исцеляющими свойствами для мышц после тренировки.

<i>Медоносы: акация, софлора, клевер, синяк, шалфей, донник.</i>',
        ]);
        $product->addMedia(
            public_path('assets/images/black_swordsman_polling.jpg')
        )->preservingOriginal()->toMediaCollection('image');

        $product->options()->create([
            'volume' => '📕 100 гр',
            'type' => 'кр. пакет',
            'price' => 900,
        ]);

        $product->options()->create([
            'volume' => '📕 500 гр ',
            'type' => 'кр. пакет',
            'price' => 3500,
        ]);

        $product->options()->create([
            'volume' => '📕 1000 гр',
            'type' => 'кр. пакет',
            'price' => 5500,
        ]);
    }
};
