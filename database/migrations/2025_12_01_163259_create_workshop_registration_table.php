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
        Schema::create('workshop_registration', function (Blueprint $table) {
            $table->id('workshop_registration_id');
            $table->foreignId('workshop_id')
                    ->constrained('workshops')
                    ->cascadeOnDelete();
            $table->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->integer('participant_count');
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
        Schema::dropIfExists('workshop_registration');
    }
};