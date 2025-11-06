<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Cache::flush();

        Product::create([
            'title' => 'Дикий Мёд',
            'description' => '(Очень крутое описание)',
            'price' => '2000',
        ])->addMedia(
            public_path('assets/images/honey.jpg')
        )->preservingOriginal()->toMediaCollection('image');

        Product::create([
            'title' => 'Яйца Валерия',
            'description' => '(Очень крутое описание)',
            'price' => '2000',
        ])->addMedia(
            public_path('assets/images/eggs.jpg')
        )->preservingOriginal()->toMediaCollection('image');
    }
}
