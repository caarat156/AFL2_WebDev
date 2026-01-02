<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')
                ->references('order_id')
                ->on('orders')
                ->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
