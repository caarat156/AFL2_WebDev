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
            $table->id('order_id');
            $table->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();
            $table->decimal('total_price', 10, 2);
            $table->date('order_date');
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_status');
            $table->string('status')->default('on process');
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
