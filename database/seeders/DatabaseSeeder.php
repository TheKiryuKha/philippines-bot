<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Cache::flush();
    }
}
