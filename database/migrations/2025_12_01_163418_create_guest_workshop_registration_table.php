<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('guest_workshop_registration', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('guest_id')
                    ->constrained('guest', 'guest_id')
                    ->cascadeOnDelete();
        
            $table->foreignId('workshop_id')
                    ->constrained('workshops')
                    ->cascadeOnDelete();
        
            $table->date('registration_date');
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->date('payment_date')->nullable();
        
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guest_workshop_registration');
    }
};
