<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $category = Category::query()->create([
            'title' => 'Мёд',
        ]);

        $product = $category->products()->create([
            'title' => '«МЁД ИЗ САЙЛЕНТ ХИЛЛА»',
            'description' => '<i>луговой мёд (разнотравье)</i>

Заброшенные шахты, туман. Окруженный терриконами город-призрак Гуково был основан в 1878 году и со временем стал прототипом вымышленного Сайлент Хилл. В нём и производится этот вкусный мёд.

<i>Медоносы: сафлора, синяк, шалфей, донник</i>',
        ]);
        $product->addMedia(
            public_path('assets/images/sillent_hill.jpg')
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
