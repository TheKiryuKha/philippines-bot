<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table): void {
            $table->id();

            $table->string('status');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('delivery_address');
            $table->string('phone');

            $table->unsignedBigInteger('price');

            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }
};
