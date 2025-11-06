<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_options', function (Blueprint $table): void {
            $table->id();

            $table->string('volume');
            $table->unsignedBigInteger('price');
            $table->string('type');

            $table->foreignId('product_id');

            $table->timestamps();
        });
    }
};
