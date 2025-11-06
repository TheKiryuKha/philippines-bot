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
            'title' => '«ЭСТУС»',
            'description' => '<i>акация</i>

Символ мира - трудности и вызовы. Каждый в нем - игрок. Игрокам требуется Эстус для восстановления ХП. Эстус представляет собой тягучую, нежную жидкость, которую можно использовать в бою для восполнения жизненных сил. Он хранится в специальной стеклянной банке, которая, по легенде, обновляется при отдыхе у костра.
Ну или при заказе очередной порции в PRIMA EST APIS.

<i>Медоносы: акация</i>',
        ]);
        $product->addMedia(
            public_path('assets/images/estus.jpg')
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
