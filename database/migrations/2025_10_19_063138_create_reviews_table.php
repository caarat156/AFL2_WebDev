<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Relasi ke products, tapi boleh null
            $table->foreignId('product_id')
                    ->nullable()
                    ->constrained('products')
                    ->onDelete('cascade');

            $table->string('name');
            $table->tinyInteger('rating'); // 1–5
            $table->text('comment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

