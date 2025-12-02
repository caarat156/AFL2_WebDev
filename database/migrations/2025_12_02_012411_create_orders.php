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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orders_id');
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('cascade');
            $table->decimal('total_price', 10, 2);
            $table->date('order_date');
            $table->string('payment_method');
            $table->decimal('payment_amount', 10, 2);
            $table->string('payment_status');
            $table->date('payment_date');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
